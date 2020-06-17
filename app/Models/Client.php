<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps = false;

    protected $fillable = [
         'id','child_id','client_status'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }


}
