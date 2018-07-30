<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [];

    function claims()
    {
        return $this->hasMany(Claim::class);
    }
}
