<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = [];

    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
