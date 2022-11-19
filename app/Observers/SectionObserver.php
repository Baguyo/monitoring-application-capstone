<?php

namespace App\Observers;

use App\Models\Section;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SectionObserver
{
    /**
     * Handle the Section "created" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function created(Section $section)
    {
        Cache::forget('allSections');
    }

    /**
     * Handle the Section "updated" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function updated(Section $section)
    {

        Cache::forget('allSections');
        Cache::forget('allStudents');
    }

    /**
     * Handle the Section "deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function deleting(Section $section)
    {
        Cache::forget('allSections');
        Cache::forget('allStudents');
        if($section->isForceDeleting()){
            $student = $section->students()->withTrashed()->get();
            $student->each(function($st){
            Storage::disk('public')->delete($st->qr_code->path);
        });
        }
    }

    /**
     * Handle the Section "deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function deleted(Section $section)
    {
        Cache::forget('allSections');
        Cache::forget('allStudents');
        $section->students()->delete();
    }

    /**
     * Handle the Section "restored" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function restored(Section $section)
    {
        Cache::forget('allSections');
        Cache::forget('allStudents');
        $section->students()->onlyTrashed()->restore();
    }

    /**
     * Handle the Section "force deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function forceDeleted(Section $section)
    {
        //
    }
}
