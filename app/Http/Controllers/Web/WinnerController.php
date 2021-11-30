<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Point;
use App\Repositories\Activities;
use App\Web\Client;
use App\Web\Period;
use App\Web\Station;
use App\Web\Winner;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $period = Period::all()->last();
        $stations = Station::where('active', 1)->get();
        $winners = [];
        foreach ($stations as $station) {
            $winners[$station->number_station] = ['clients' => []];
        }
        if ($period) {
            $idsClients = [];
            foreach (Point::where('points', '>', 0)->with(['client.user', 'station'])->orderBy('points', 'desc')->get() as $point) {
                if (!in_array($point->client_id, $idsClients)) {
                    if (count($winners[$point->station->number_station]['clients']) < 20) {
                        array_push($winners[$point->station->number_station]['clients'], $point->client);
                        array_push($idsClients, $point->client_id);
                    }
                }
            }
        }
        $seeWinner = $period ? ($period->winner ? false : true) : false;
        return view('winners.index', ['stations' => $stations, 'winners' => $winners, 'seeWinner' => $seeWinner, 'currentperiod' => $period]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectWinner(Request $request, Client $client, $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $stationdb = Station::where('number_station', $station)->first();
        if (!Winner::where([['client_id', $client->id], ['station_id', $stationdb->id]])->exists())
            Winner::create(['client_id' => $client->id, 'station_id' => $stationdb->id]);
        $client->winner = 1;
        $client->save();
        $notify = new Activities();
        $notify->sendNotification(
            $client->ids,
            'Pronto recibirás una llamada de la estación para recibir más información.',
            '¡GANASTE!'
        );
        // Enviar notificacion de ganador
        return redirect()->back()->withStatus("Se ha selecionado el ganador de la estación {$stationdb->name}");
    }
}
