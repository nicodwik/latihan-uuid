<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserRegisteredEvent;
use App\Mail\UserRegisteredMail;
use Mail;


class SendEmailNotificationUserRegistered implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
       Mail::to($event->user->email)->send(new UserRegisteredMail($event->user));
    }
}
