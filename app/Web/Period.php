<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = ['date_start', 'date_end', 'winner', 'finish', 'terms'];
}
