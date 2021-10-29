<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class ExcelSale extends Model
{
    protected $fillable = ['station_id', 'ticket', 'date', 'product', 'liters', 'payment', 'photo', 'status_id', 'active'];
    // Relacion con la estacion
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
