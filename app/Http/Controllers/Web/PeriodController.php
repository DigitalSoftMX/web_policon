<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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

        request()->validate([
            'date_start' =>  $lastperiod ? "required|date_format:Y-m-d H:i|after:{$lastperiod->date_end}" : 'required|date_format:Y-m-d H:i',
            'date_end' => 'required|date_format:Y-m-d H:i|after:date_start',
        ]);       
        $request->merge(['start' => $request->initperiod, 'end' => $request->endperiod, 'winner' => 0]);
        
        Period::create($request->only(['date_start', 'date_end']));
        return redirect()->back()->withStatus('Nuevo periodo de promocion iniciado');
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
        $period->update(['finish' => 1]);
        return redirect()->back()->withStatus('Se ha finalizado el concurso. Elija el ganador');
    }
}
