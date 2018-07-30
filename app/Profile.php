<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $fillable = [
        'account_number', 'phone_number', 'national_id', 'date_of_birth', 'user_id'
    ];
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
