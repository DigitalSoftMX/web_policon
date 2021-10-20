<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Point;
use App\Web\Client;
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
        $stations = Station::where('active', 1)->get();
        $seeWinner = $stations->where('winner', 0)->count() > 0 ? true : false;
        /* $ids = [];
        $winners = [];
        $stations = Station::where('active', 1)->get();
        $seeWinner = $stations->where('winner', 0)->count() > 0 ? true : false;
        foreach ($stations as $station) {
            $winners[$station->number_station] = ['clients' => []];
        }
        $limit = count($winners) * 20;
        foreach (Client::where('points', '>', 0)->orderBy('points', 'desc')->get() as $client) {
            $total = 0;
            foreach ($winners as $winner) {
                $total += count($winner['clients']);
            }
            if ($total >= $limit)
                break;
            $tickets = [];
            foreach ($stations as $station) {
                $data['tickets'] = $client->qrs->where('station_id', $station->id)->sum('points');
                $data['station'] = $station->number_station;
                array_push($tickets, $data);
            }
            rsort($tickets);
            $tickets = reset($tickets);
            if (!in_array($client->id, $ids) and $tickets['tickets'] > 0) {
                if (count($winners[$tickets['station']]['clients']) < 20) {
                    array_push($winners[$tickets['station']]['clients'], $client);
                    array_push($ids, $client->id);
                }
            }
        } */
        // return view('winners.index', ['winners' => $winners, 'stations' => $stations, 'seeWinner' => $seeWinner]);
        $ids = [];
        $winners = [];
        $stations = Station::where('active', 1)->get();
        $seeWinner = $stations->where('winner', 0)->count() > 0 ? true : false;
        foreach ($stations as $station) {
            $winners[$station->number_station] = ['clients' => []];
        }
        foreach ($stations as $station) {
            if (($qrs = $station->puntos->sortByDesc('points'))->count() > 0) {
                foreach ($qrs as $qr) {
                    if (count($winners[$station->number_station]['clients']) >= 20)
                        break;
                    array_push($winners[$station->number_station]['clients'], $qr->client);
                }
            }
        }
        return view('winners.index', ['stations' => $stations, 'winners' => $winners, 'seeWinner' => $seeWinner]);
    }
    // Finalizar el concurso
    public function finishCompetition(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        Station::where('active', 1)->update(['winner' => 1]);
        return redirect()->back()->withStatus('Se ha finalizado el concurso. Elija el ganador');
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
        // Enviar notificacion de ganador
        return redirect()->back()->withStatus("Se ha selecionado el ganador de la estación {$stationdb->name}");
    }
}
