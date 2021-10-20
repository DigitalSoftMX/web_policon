<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\User;
use Illuminate\Http\Request;
use App\Web\Client;
use App\Web\Exchange;
use App\Web\SalesQr;
use App\Web\Station;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    // Metodo para buscar un grupo de clientes
    public function lookingForClients(Request $request, $view = false)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $empty = false;
        foreach ($request->only('membership', 'name', 'lastname', 'email') as $var) {
            if ($var)
                $empty = true;
        }
        if (!$empty)
            $request->validate(['empty' => 'required']);
        $query = array();
        if ($request->membership) {
            $request->validate(['membership' => 'min:6']);
            array_push($query, ['membership', 'LIKE', "%$request->membership%"]);
        }
        if ($request->name) {
            $request->validate(['name' => 'min:2']);
            array_push($query, ['name', 'LIKE', "%$request->name%"]);
        }
        if ($request->lastname) {
            $request->validate(['lastname' => 'min:2']);
            switch (count($lastname = explode(" ", $request->lastname))) {
                case 1:
                    array_push($query, ['first_surname', 'LIKE', '%' . $lastname[0] . '%']);
                    break;
                case 2:
                    array_push($query, ['first_surname', 'LIKE', '%' . $lastname[0] . '%']);
                    array_push($query, ['second_surname', 'LIKE', '%' . $lastname[1] . '%']);
                    break;
                default:
                    array_push($query, ['first_surname', 'LIKE', "%$request->lastname%"]);
                    break;
            }
        }
        if ($request->email) {
            $request->validate(['email' => 'email']);
            array_push($query, ['email', 'LIKE', "%$request->email%"]);
        }
        $users = array();
        foreach (User::where($query)->get() as $user) {
            if ($user->roles->first()->id == 5)
                array_push($users, $user);
        }
        return $view ? redirect()->back()->withUsers($users) : view('clients.index', compact('users'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        return view('clients.lookingforclients');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        return view('clients.show', ['client_id' => $id]);
    }
    // Método para buscar los canjes del cliente
    public function points(Request $request, Client $client)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        return view('clients.points', compact('client'));
    }
    // Metodo para obtener el historial de puntos
    public function historypoints(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $client = Client::find($request->client_id);
        $arrayPointsAdded = array();
        // $arrayPointsSubstracted = array();
        foreach (Station::where('active', 1)->get() as $station) {
            $qrs = $station->qrs->where('client_id', $client->id)->where('active', 1)->where('created_at', '>=', $request->inicial)->where('created_at', '<=', $request->final)->sortBy('created_at');
            if ($qrs->count() > 0) {
                $tempDate = $qrs->first()->created_at->format('Ymd');
                $register = 0;
                foreach ($qrs as $qr) {
                    $qr->created_at->format('Ymd') == $tempDate ? $register++ : $register = 1;
                    $data['sale'] = $qr->sale;
                    $data['station'] = $qr->station->name;
                    $data['liters'] = $qr->liters;
                    $data['points'] = $qr->points;
                    $data['concepto'] = $register;
                    $data['date'] = $qr->created_at->format('Y/m/d H:i:s');
                    array_push($arrayPointsAdded, $data);
                }
            }
        }

        /* if (($exchanges = Exchange::where([['client_id', $client->id], ['status', 14]])->whereDate('created_at', '>=', $request->inicial)->whereDate('created_at', '<=', $request->final)->get()) != null) {
            foreach ($exchanges as $pS) {
                $data['exchange'] = $pS->exchange;
                $data['station'] = $pS->station->name;
                $data['status'] = $pS->estado->name;
                $data['points'] = $pS->points;
                $data['type'] = 'Vale';
                $data['date'] = $pS->created_at->format('Y/m/d H:i:s');
                array_push($arrayPointsSubstracted, $data);
            }
        } */
        return response()->json([
            'pointsadded' => $arrayPointsAdded,
            // 'pointsubstracted' => $arrayPointsSubstracted,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $client, $route = false)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        return view('clients.edit', ['user' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, User $client)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $hasPassword = $request->get('password');
        $client->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$hasPassword ? '' : 'password'])
        );
        return redirect()->route('clients.index')->withStatus(__('Actualización éxitosa'));
    }

    public function search_client(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $info_movimientos = Client::find($request->client_id);
        $deposits = $info_movimientos->deposits->whereBetween('created_at', [$request->inicial, $request->final]);

        $array_depositos_final = [];
        $array_depositos = array();

        $array_transferencias_final = [];
        $array_transferencias = array();

        $array_transferencias_final_2 = [];
        $array_transferencias_2 = array();

        $array_pagos_final = [];
        $array_pagos = array();

        foreach ($deposits as $deposit) {
            array_push($array_depositos, $deposit->balance);
            array_push($array_depositos, $deposit->points);
            array_push($array_depositos, $deposit->image_payment);
            array_push($array_depositos, $deposit->station->name);
            array_push($array_depositos, $this->status($deposit->status));
            array_push($array_depositos, $deposit->created_at->format('Y-m-d H:m:s'));
            array_push($array_depositos_final, $array_depositos);
            $array_depositos = [];
        }

        $transferencias = $info_movimientos->shareds->whereBetween('created_at', [$request->inicial, $request->final]);

        foreach ($transferencias as $transferencia) {
            array_push($array_transferencias, $transferencia->receiver->membership);
            array_push($array_transferencias, $transferencia->balance);
            array_push($array_transferencias, $transferencia->station->name);
            array_push($array_transferencias, $this->status($transferencia->status));
            array_push($array_transferencias, $transferencia->created_at->format('Y-m-d H:m:s'));
            array_push($array_transferencias_final, $array_transferencias);
            $array_transferencias = [];
        }

        $transferencias_2 = $info_movimientos->receivers->whereBetween('created_at', [$request->inicial, $request->final]);

        foreach ($transferencias_2 as $transferencia_1) {
            array_push($array_transferencias_2, $transferencia_1->transmitter->membership);
            array_push($array_transferencias_2, $transferencia_1->balance);
            array_push($array_transferencias_2, $transferencia_1->station->name);
            array_push($array_transferencias_2, $this->status($transferencia_1->status));
            array_push($array_transferencias_2, $transferencia_1->created_at->format('Y-m-d H:m:s'));
            array_push($array_transferencias_final_2, $array_transferencias_2);
            $array_transferencias_2 = [];
        }

        $pagos = $info_movimientos->payments->whereBetween('created_at', [$request->inicial, $request->final]);

        foreach ($pagos as $pago) {
            array_push($array_pagos, $pago->sale);
            array_push($array_pagos, $this->gasoline($pago->gasoline_id));
            array_push($array_pagos, $pago->liters);
            array_push($array_pagos, $pago->payment);
            array_push($array_pagos, $pago->station->name);
            array_push($array_pagos, $pago->no_island);
            array_push($array_pagos, $pago->no_bomb);
            array_push($array_pagos, $pago->created_at->format('Y-m-d H:m:s'));
            array_push($array_pagos_final, $array_pagos);
            $array_pagos = [];
        }


        return response()->json([
            'deposits' => $array_depositos_final,
            'transfers' => $array_transferencias_final,
            'transfers_2' => $array_transferencias_final_2,
            'payments' => $array_pagos_final,
        ]);
    }
    // Metodo para la vista de los canjes
    public function exchange(Request $request, Client $client)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        return view('clients.exchanges', compact('client'));
    }
    // Metodo para obenter historial de los canjes
    public function getexchanges(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $client = Client::find($request->client_id);
        $process = array();
        $history = array();
        if (($exchanges = Exchange::where([['client_id', $client->id], ['status', '!=', 14]])->whereDate('created_at', '>=', $request->inicial)->whereDate('created_at', '<=', $request->final)->get()) != null) {
            foreach ($exchanges as $exchange) {
                $data['exchange'] = $exchange->exchange;
                $data['station'] = $exchange->station->name;
                $data['status'] = $exchange->estado->name;
                $data['date'] = $exchange->created_at->format('Y/m/d H:i:s');
                array_push($process, $data);
            }
        }
        if (($exchanges = Exchange::where([['client_id', $client->id], ['status', 14]])->whereDate('created_at', '>=', $request->inicial)->whereDate('created_at', '<=', $request->final)->get()) != null) {
            foreach ($exchanges as $exchange) {
                $data['exchange'] = $exchange->exchange;
                $data['station'] = $exchange->station->name;
                $data['status'] = $exchange->estado->name;
                $data['admin'] = $exchange->admin->name . ' ' . $exchange->admin->first_surname . ' ' . $exchange->admin->second_surname;
                $data['date'] = $exchange->created_at->format('Y/m/d H:i:s');
                array_push($history, $data);
            }
        }
        return response()->json([
            'process' => $process,
            'history' => $history,
        ]);
    }

    public function status($status)
    {
        switch ($status) {
            case 1:
                $status = "Pendiente";
                break;
            case 2:
                $status = "Activado";
                break;
            case 3:
                $status = "Denegado";
                break;
            case 4:
                $status = "Disponible";
                break;
            case 5:
                $status = "Compartido";
                break;
        }
        return $status;
    }

    public function gasoline($gasoline_id)
    {
        switch ($gasoline_id) {
            case 1:
                $gasoline_id = "Magna";
                break;
            case 2:
                $gasoline_id = "Premium";
                break;
            case 3:
                $gasoline_id = "Diésel";
                break;
        }
        return $gasoline_id;
    }
}
