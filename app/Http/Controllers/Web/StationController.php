<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StationRequest;
use App\Imports\SalesImport;
use App\Point;
use App\Repositories\Activities;
use App\Web\ExcelSale;
use App\Web\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Web\SalesQr;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('stations.index', ['stations' => Station::where('active', 1)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('stations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StationRequest $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        request()->validate(['station' => 'required|image']);
        $image = $request->file('station')->store('public');
        $request->merge(['image' => Storage::url($image)]);
        Station::create($request->all());
        return redirect()->route('stations.index')->withStatus('Estacion registrada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);

        $station_show = array();

        $array_meses_espanol = [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];

        $array_meses_espanol_corto = [
            "Jan" => "Ene", "Feb" => "Feb", "Mar" => "Mar", "Apr" => "Abr",
            "May" => "May", "Jun" => "Jun", "Jul" => "Jul", "Aug" => "Ago",
            "Sep" => "Sep", "Oct" => "Oct", "Nov" => "Nov", "Dec" => "Dic"
        ];
        // array para los meses
        $array_meses = [];
        $meses_hasta_el_actual = [];
        //for para llenar el array con los meses hasta el actual
        for ($i = 1; $i <= 11; $i++) {
            array_push($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))));
            array_push($array_meses, $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))))]);
        }

        array_unshift($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m"), 28, date("Y"))));
        array_unshift($array_meses,  $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m"), 28, date("Y"))))]);

        $station_show['meses'] = array_reverse($array_meses);
        $station_show['meses_largos'] = $array_meses_espanol;
        $meses_hasta_el_actual = array_reverse($meses_hasta_el_actual);

        $station = $request->user()->station(Auth::user(), $station);
        $mes_anterior = date('m', strtotime('-1 month'));
        $mes_actual = date('m');
        $year = date('Y');

        $lastMont = 0;
        $actualMont = 0;

        if ($lastMont > 0) {
            $liters = number_format((($actualMont / $lastMont) - 1) * 100, 2);
        } else {
            $liters = $lastMont * 100;
        }

        $lastMontSales = 0;
        $actualMontSales = 0;

        if ($lastMontSales > 0) {
            $sales = number_format((($actualMontSales / $lastMontSales) - 1) * 100, 2);
        } else {
            $sales = $lastMontSales * 100;
        }

        $total_magna = 0;
        $total_premium = 0;
        $total_diesel = 0;

        $station_show['tickets'] = 0;
        $station_show['liters'] = 0;
        $station_mouths_magna = [];
        $station_mouths_premium = [];
        $station_exchange_mounths_1 = [];
        $station_tickets_mounths_1 = [];

        for ($mes = 0; $mes <= 11; $mes++) {
            array_push($station_mouths_premium, 0);
            array_push($station_mouths_premium, 0);
        }

        for ($yearN = 0; $yearN < 3; $yearN++) {
            for ($mes = 0; $mes <= 11; $mes++) {
                array_push($station_exchange_mounths_1, 0);
                array_push($station_tickets_mounths_1, 0);
            }
        }

        $station_show['magna'] = $station_mouths_magna;
        $station_show['premium'] = $station_mouths_premium;
        $station_show['vales_meses'] = array_chunk($station_exchange_mounths_1, 12);
        $station_show['tickets_meses'] = array_chunk($station_tickets_mounths_1, 12);

        return view('stations.show', [
            'station_show' => $station_show, 'station' => $station, 'liters' => $liters, 'sales' => $sales,
            'estacion_dashboard' => $request->estacion_dashboard, 'total_magna' => $total_magna,
            'total_premium' => $total_premium, 'total_diesel' => $total_diesel
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('stations.edit', compact('station'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StationRequest $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        if ($request->file('station')) {
            request()->validate(['station' => 'image']);
            if (File::exists(public_path() . $station->image)) {
                File::delete(public_path() . $station->image);
            }
            $logo = $request->file('station')->store('public');
            $request->merge(['image' => Storage::url($logo)]);
        }
        $station->update($request->all());
        return redirect()->route('stations.index')->withStatus('Estación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        if (File::exists(public_path() . $station->image)) {
            File::delete(public_path() . $station->image);
        }
        $station->update(['active' => 0]);
        return redirect()->back()->withStatus('Se ha eliminado la estación');
    }

    // Subiendo ventas de la estacion por excel
    public function uploadexcelsales(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        request()->validate(['excel' => 'required|mimes:csv,xlsx,xls,ods']);
        $date = null;
        try {
            Excel::import($sales = new SalesImport($station), $request->file('excel'));
            $date = $sales->getDate();
        } catch (Exception $e) {
            return redirect()->back()->withStatus('Algo salio mal, revise el formato excel para esta estación');
        }
        $idsClientsAcepted = [];
        $idsClientVerify = [];
        $idsClientDenied = [];
        foreach (SalesQr::where([['station_id', $station->id], ['status_id', '!=', 2]])
            ->whereDate('created_at', $date)->get() as $qr) {
            if (stristr($qr->sale, '0000000')) {
                $sale = ExcelSale::where([
                    ['station_id', $qr->station_id], ['ticket', $qr->sale], ['date', $qr->created_at->format('Y-m-d H:i:s')],
                    ['liters', $qr->liters], ['payment', $qr->payment],
                ])->get()->first();
                if ($sale and (str_contains($qr->product, $sale->product) or str_contains($sale->product, $qr->product))) {
                    $points = 10;
                    $division = intval($qr->payment / 500);
                    $points *= $division;
                    $qr->update(['points' => $points, 'status_id' => 2]);
                    if ($poinstation = $qr->client->puntos->where('station_id', $station->id)->first()) {
                        $poinstation->points += $points;
                        $poinstation->save();
                    } else {
                        Point::create(['client_id' => $qr->client_id, 'station_id' => $station->id, 'points' => $points]);
                    }
                    if (!in_array($qr->client->ids, $idsClientsAcepted)) array_push($idsClientsAcepted, $qr->client->ids);
                } else {
                    if (ExcelSale::where([['ticket', $qr->sale], ['station_id', $station->id]])->exists()) {
                        if (!in_array($qr->client->ids, $idsClientVerify) and $qr->status_id == 1)
                            array_push($idsClientVerify, $qr->client->ids);
                        $qr->update(['status_id' => 3]);
                    } else {
                        if (!in_array($qr->client->ids, $idsClientDenied) and $qr->status_id == 1)
                            array_push($idsClientDenied, $qr->client->ids);
                        $qr->update(['status_id' => 4]);
                    }
                }
            } else {
                if (!in_array($qr->client->ids, $idsClientVerify) and $qr->status_id == 1)
                    array_push($idsClientVerify, $qr->client->ids);
                $qr->update(['status_id' => 3]);
            }
        }
        $notify = new Activities();
        foreach ($idsClientsAcepted as $ids) {
            $notify->sendNotification($ids, 'Sus puntos han sido sumados.');
        }
        foreach ($idsClientVerify as $ids) {
            $notify->sendNotification($ids, 'Sus puntos no pudieron sumarse, revise que los datos sean correctos.');
        }
        foreach ($idsClientDenied as $ids) {
            $notify->sendNotification($ids, 'Sus puntos no pudieron sumarse, el ticket no es válido.');
        }
        return redirect()->back()->withStatus('Ventas cargadas correctamente.');
    }
}
