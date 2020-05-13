<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'count', 'group_id','id',
        'place_date', 'place_time', 'max_count'
    ];
}
