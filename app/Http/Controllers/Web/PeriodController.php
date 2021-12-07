<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Point;
use App\Repositories\Activities;
use App\Web\Client;
use App\Web\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        $lastperiod = Period::all()->last();
        $request->merge([
            'date_start' => "{$request->date_start} {$request->hour_start}",
            'date_end' => "{$request->date_end} {$request->hour_end}"
        ]);
        request()->validate([
            'hour_start' => 'required|date_format:H:i', 'hour_end' => 'required|date_format:H:i',
            'date_start' =>  $lastperiod ? "required|date_format:Y-m-d H:i|after:{$lastperiod->date_end}" : 'required|date_format:Y-m-d H:i',
            'date_end' => 'required|date_format:Y-m-d H:i|after:date_start', 'terms' => 'required|string'
        ]);
        Period::create($request->only(['date_start', 'date_end', 'terms']));
        Point::where('points', '>', 0)->update(['points', 0]);
        Client::where('active', 1)->update(['winner' => 0]);
        return redirect()->back()->withStatus('Nuevo periodo de promoción iniciado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Period $period)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        $request->conditions ? $period->update(['terms' => $request->conditions]) : $period->update(['finish' => 1]);
        if ($period->finish) {
            $idsClients = [];
            foreach (Point::where('points', '>', 0)->get() as $point) {
                if (!in_array($point->client->ids, $idsClients))
                    array_push($idsClients, $point->client->ids);
            }
            $notify = new Activities();
            foreach ($idsClients as $ids) {
                $notify->sendNotification($ids, 'Gracias por participar: Mantente al pendiente de la app y nuestras redes sociales, pronto daremos a conocer a nuestros ganadores');
            }
        }
        return $request->conditions ?
            redirect()->back()->withStatus('Términos y condiciones actualizados correctamente') :
            redirect()->back()->withStatus('Se ha finalizado el concurso. Elija el ganador');
    }
}
