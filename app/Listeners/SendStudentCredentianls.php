<?php

namespace App\Listeners;

use App\Events\StudentCreation;
use App\Mail\NotifyStudentCreation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendStudentCredentianls
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
    public function handle(StudentCreation $event)
    {
        Mail::to($event->student->user)->send(
            new NotifyStudentCreation($event->student)
        ); 
    }
}
