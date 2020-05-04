<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'day', 'id'
    ];

    public function hours()
    {
        return $this->hasMany(Hour::class);
    }
}
