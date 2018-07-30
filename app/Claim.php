<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = [];
    function product()
    {
        return $this->belongsTo(Product::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function proof()
    {
        return $this->hasMany(Proof::class);
    }
}
