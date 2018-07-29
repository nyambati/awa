<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\UserActivationEmail;

use Mail;

class SendActivationLink implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $tries = 10;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        Mail::to($event->user->email)->send(new UserActivationEmail($event->user));
    }
}
