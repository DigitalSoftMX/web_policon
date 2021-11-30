<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = ['date_start', 'hour_start', 'date_end', 'hour_end', 'winner', 'finish'];
}
