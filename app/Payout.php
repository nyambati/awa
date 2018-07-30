<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [];

    function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
