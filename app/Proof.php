<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proof extends Model
{
    protected $fillable = [];

    function claim()
    {
        return $this->belongsTo(Claim::class);
    }
}
