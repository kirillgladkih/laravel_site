<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procreator extends Model
{
    public $timestamps = false;

    protected $fillable = [
         'id', 'fio','phone'
    ];

    public function children()
    {
        return $this->hasMany(Child::class);
    }
}
