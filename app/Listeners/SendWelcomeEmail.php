<?php

namespace App\Listeners;

use App\Events\UserAccountActivated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\UserWelcomeEmail;

use Mail;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserAccountActivated  $event
     * @return void
     */
    public function handle(UserAccountActivated $event)
    {
        Mail::to($event->user->email)->send(new UserWelcomeEmail($event->user));
    }
}
