<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        $ids = [];
        $winners = [];
        $stations = Station::where('active', 1)->get();
        foreach ($stations as $station) {
            $winners[$station->number_station] = ['clients' => []];
        }
        $limit = count($winners) * 20;
        foreach (Client::orderBy('points', 'desc')->get() as $client) {
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
        }
        return view('winners.index', ['winners' => $winners, 'stations' => $stations]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectWinner(Client $client, $station)
    {
        $stationdb = Station::where('number_station', $station)->first();
        if ($stationdb->winner == 0) {
            $stationdb->update(['winner' => 1]);
            if (!Winner::where([['client_id', $client->id], ['station_id', $stationdb->id]])->exists())
                Winner::create(['client_id' => $client->id, 'station_id' => $stationdb->id]);
            return redirect()->back()->withStatus("Se ha selecionado el ganador de la estación {$stationdb->name}");
        }
        return redirect()->back()->withStatus('La estación ya cuenta con un ganador');
    }
}
