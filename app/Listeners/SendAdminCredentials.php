<?php

namespace App\Listeners;

use App\Events\AdminCreation;
use App\Mail\NotifyAdminCreation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAdminCredentials
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
    public function handle(AdminCreation $event)
    {
        Mail::to($event->user)->send(
            new NotifyAdminCreation($event->user)
        ); 
    }
}
