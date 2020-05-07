<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{   
    public $timestamps = false;

    protected $fillable = [
        'record_date', 'id', 'begin', 'end', 'count_record','child_id'
    ];
}
