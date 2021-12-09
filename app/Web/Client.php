<?php

namespace App\Web;

use App\Point;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['winner', 'sex', 'birthdate'];
    // Relacion con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relacion con los puntos escaneados
    public function qrs()
    {
        return $this->hasMany(SalesQr::class);
    }
    // Relacion con los puntos por estacion
    public function puntos()
    {
        return $this->hasMany(Point::class);
    }
}
