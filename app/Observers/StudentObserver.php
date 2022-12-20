<?php

namespace App\Observers;

use App\Models\student;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class StudentObserver
{
    /**
     * Handle the student "created" event.
     *
     * @param  \App\Models\student  $student
     * @return void
     */
    public function created(student $student)
    {
        if(Cache::has('allStudents')){
            Cache::forget('allStudents');
        }
    }

    /**
     * Handle the student "updated" event.
     *
     * @param  \App\Models\student  $student
     * @return void
     */
    public function updated(student $student)
    {
        Cache::forget('allStudents');
    }

    // /**
    //  * Handle the student "deleted" event.
    //  *
    //  * @param  \App\Models\student  $student
    //  * @return void
    //  */
    // public function deleted(student $student)
    // {
    //     Cache::forget('allStudents');
    //     $student->qr_code()->delete();
        
    // }

    // /**
    //  * Handle the student "restored" event.
    //  *
    //  * @param  \App\Models\student  $student
    //  * @return void
    //  */
    // public function restored(student $student)
    // {
    //     Cache::forget('allStudents');
    //     $student->qr_code()->onlyTrashed()->restore();
    // }

    
}
