<?php

namespace App\Http\Controllers;

use App\Repositories\Activities;
use App\Web\Station;
use App\Web\Client;
use App\Web\SalesQr;
use Illuminate\Http\Request;
use App\Web\AdminStation;
use App\Web\Period;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion',]);
        // redireccionar al usuario con rol administrador de estación
        if (auth()->user()->roles->first()->name == 'admin_estacion') {
            $admin_station = AdminStation::where('user_id', $request->user()->id)->first();
            return redirect()->route('stations.show', ['station' => Station::find($admin_station->station_id), 'estacion_dashboard' => 'dashboard']);
        } else {
            // obteniendo ventas, ultimo periodo registrado y numero de clientes
            $month = new Activities();
            $sales = SalesQr::where('status_id', 2)->get();
            $currentPeriod = Period::all()->last();
            $litersInThisPeriod = $currentPeriod ?
                $sales->where('created_at', '>=', $currentPeriod->date_start)->where('created_at', '<=', $currentPeriod->date_end)->sum('liters') :
                $sales->where('created_at', '>=', date('Y') . '-01-01')->where('created_at', '<=', date('Y') . '-12-31')->sum('liters');
            $months = [$month->getNameMonthSpanish($currentPeriod->date_start), $month->getNameMonthSpanish($currentPeriod->date_end)];
            $period = $currentPeriod ? "{$months[0][0]} - {$months[1][0]}" : 'Ene - Dic';
            $clients = Client::all();
            $stations = Station::where('active', 1)->with('qrs')->get();
            // Ventas totales por estacion
            $totalSales = [];
            foreach ($stations as $station) {
                array_push($totalSales, [
                    'station' => $station->name,
                    'total' => $station->qrs->where('status_id', 2)->sum('liters'),
                ]);
            }
            // Ventas totales por periodo por estacion
            $periodSales = [];
            foreach ($stations as $station) {
                array_push($periodSales, [
                    'station' => $station->name,
                    'total' => $period ? $station->qrs()->where([
                        ['created_at', '>=', $currentPeriod->date_start], ['created_at', '<=', $currentPeriod->date_end],
                        ['status_id', 2]
                    ])->sum('liters') : 0,
                ]);
            }

            /* $date = date("Y-m-d", strtotime($currentPeriod->date_start . "- 1 days"));
            $date = date("Y-m-d", strtotime($date . "+ 1 days")); 
            date("d", strtotime($date)),*/

            $salesPerDay = [
                'days' => [],
                'salesFmonth' => [],
                'salesSmonth' => [],
            ];
            $fmonth = date('Y-m', strtotime($currentPeriod->date_start));
            $smonth = date('Y-m', strtotime($currentPeriod->date_end));
            $lastDayOfFmonth = date('t', strtotime($currentPeriod->date_start));
            $lastDayOfSmonth = date('t', strtotime($currentPeriod->date_end));
            $lastDay = $lastDayOfFmonth > $lastDayOfSmonth ? $lastDayOfFmonth : $lastDayOfSmonth;
            for ($i = 1; $i <= $lastDay; $i++) {
                $day = $i < 10 ? "0{$i}" : "{$i}";
                array_push($salesPerDay['days'], $day);
                $liters = SalesQr::where('status_id', 2)->whereDate('created_at', "{$fmonth}-{$day}")->sum('liters');
                array_push($salesPerDay['salesFmonth'], $liters);
                $liters = SalesQr::where('status_id', 2)->whereDate('created_at', "{$smonth}-{$day}")->sum('liters');
                array_push($salesPerDay['salesSmonth'], $liters);
            }

            return view('dashboard', [
                'totalclients' => $clients->count(), 'litersInThisPeriod' => number_format($litersInThisPeriod, 2),
                'tickets' => $sales->count(), 'totaliters' => number_format($sales->sum('liters'), 2),
                'clientsCurrentMonth' => $clients->where('created_at', 'like', '%' . date('Y-m') . '%')->count(),
                'period' => $period, 'currentperiod' => $currentPeriod,
                'start' => $currentPeriod ? date("m-d-Y", strtotime($currentPeriod->date_end . "+ 1 minute")) : date('m-d-Y'),
                'hour' => $currentPeriod ? date("H:i", strtotime($currentPeriod->date_end . "+ 1 minute")) : date('H:i'),
                'stations' => $stations, 'totalSales' => $totalSales, 'periodSales' => $periodSales,
                'totalPerDay' => $salesPerDay, 'months' => $months
            ]);
        }
    }

    public function litersMountYears(Request $request)
    {

        $stations = Station::all();
        $stations_year = [];

        $one = $request->mountOne;
        $two = $request->mountTwo;

        if ($one < 10) {
            $one = '0' . $one;
        }

        if ($two < 10) {
            $two = '0' . $two;
        }

        foreach ($stations as $valor) {
            array_push($stations_year, number_format(SalesQr::where([['station_id', $valor->id], ['created_at', 'like', '%' . date('Y') . '-' . $one . '%']])->sum('liters')));
        }

        foreach ($stations as $valor) {
            array_push($stations_year, number_format(SalesQr::where([['station_id', $valor->id], ['created_at', 'like', '%' . (date('Y') - 1) . '-' . $two . '%']])->sum('liters')));
        }

        return response()->json(['chartYears' => array_chunk($stations_year, 8)]);
    }
}
