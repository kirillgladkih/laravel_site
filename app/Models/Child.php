<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    public $timestamps = false;

    protected $fillable = [
         'id', 'fio', 'procreator_id', 'age'
    ];

    public function parent()
    {
        return $this->belongsTo(Procreator::class,'procreator_id');
    }
}
