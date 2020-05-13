<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{   
    public $timestamps = false;

    protected $fillable = [
        'record_date', 'id', 'record_time', 'child_id'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
