<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class ExcelSale extends Model
{
    protected $fillable = ['station_id', 'ticket', 'date', 'product', 'liters', 'payment'];
    // Relacion con la estacion
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
