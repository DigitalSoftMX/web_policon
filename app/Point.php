<?php

namespace App;

use App\Web\Client;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = ['client_id', 'station_id', 'points'];
    // Relacion con los cliente
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
