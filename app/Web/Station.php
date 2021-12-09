<?php

namespace App\Web;

use App\Point;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'station';

    protected $fillable = ['name', 'address', 'phone', 'email', 'number_station', 'active', 'image', 'winner'];
    // Relacion con las ventas por qr
    public function qrs()
    {
        return $this->hasMany(SalesQr::class);
    }
    // Relacion con los puntos del cliente
    public function puntos()
    {
        return $this->hasMany(Point::class);
    }
    // Relacion con los ganadores
    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
    // Relacion con las ventas excel
    public function excelsales()
    {
        return $this->hasMany(ExcelSale::class);
    }
}
