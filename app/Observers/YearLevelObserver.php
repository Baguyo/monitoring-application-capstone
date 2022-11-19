<?php

namespace App\Observers;

use App\Models\YearLevel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class YearLevelObserver
{
    /**
     * Handle the YearLevel "created" event.
     *
     * @param  \App\Models\YearLevel  $yearLevel
     * @return void
     */
    public function created(YearLevel $yearLevel)
    {
        Cache::forget('allYearLevel');
        
    }


    public function creating(YearLevel $yearLevel)
    {
        
    }

    /**
     * Handle the YearLevel "updated" event.
     *
     * @param  \App\Models\YearLevel  $yearLevel
     * @return void
     */
    public function updated(YearLevel $yearLevel)
    {
        Cache::forget('allYearLevel');
        Cache::forget('allSections');
        Cache::forget('allStudents');
    }



        /**
     * Handle the YearLevel "deleted" event.
     *
     * @param  \App\Models\YearLevel  $yearLevel
     * @return void
     */
    public function deleting(YearLevel $yearLevel)
    {
        Cache::forget('allYearLevel');
        Cache::forget('allSections');
        Cache::forget('allStudents');
        if($yearLevel->isForceDeleting()){
            $section = $yearLevel->sections()->withTrashed()->get();
            $section->each(function($item){
            $student = $item->students()->withTrashed()->get();
            $student->each(function($st){
                Storage::disk('public')->delete($st->qr_code->path);
            });
        });
        }
    }


    /**
     * Handle the YearLevel "deleted" event.
     *
     * @param  \App\Models\YearLevel  $yearLevel
     * @return void
     */
    public function deleted(YearLevel $yearLevel)
    {
        
        Cache::forget('allYearLevel');
        Cache::forget('allSections');
        Cache::forget('allStudents');
        $sections = $yearLevel->sections->collect();
        $sections->each(function($item){
            $item->students()->delete();
        });
        // dd($student);
        $yearLevel->sections()->delete();
    }



    /**
     * Handle the YearLevel "restored" event.
     *
     * @param  \App\Models\YearLevel  $yearLevel
     * @return void
     */
    public function restored(YearLevel $yearLevel)
    {
        Cache::forget('allYearLevel');
        Cache::forget('allSections');
        Cache::forget('allStudents');
        $yearLevel->sections()->onlyTrashed()->restore();

        $section = $yearLevel->sections->collect();
        $section->each(function($item){
            $item->students()->restore();
        });
    }

    public function restoring(YearLevel $yearLevel)
    {
        
    }

    /**
     * Handle the YearLevel "force deleted" event.
     *
     * @param  \App\Models\YearLevel  $yearLevel
     * @return void
     */
    public function forceDeleted(YearLevel $yearLevel)
    {
        
    }
}
