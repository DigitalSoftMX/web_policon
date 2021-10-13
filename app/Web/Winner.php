<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    protected $fillable = ['client_id', 'station_id'];
}
