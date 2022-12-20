<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyStudentCreation extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Student $student, $password)
    {
        $this->student = $student;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.admin.student-creation-markdown');
    }
}
