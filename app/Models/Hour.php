<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'day_id', 'id', 'hour', 'group_id', 'status', 'count'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
