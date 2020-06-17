<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'fio', 'procreator_id', 'age', 'group_id'
    ];

    public function parent()
    {
        return $this->belongsTo(Procreator::class,'procreator_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }
}
