<?php

namespace App\Observers;

use App\Models\strands;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class StrandObserver
{
    /**
     * Handle the strands "created" event.
     *
     * @param  \App\Models\strands  $strands
     * @return void
     */
    public function created(strands $strands)
    {
        //
    }

    /**
     * Handle the strands "updated" event.
     *
     * @param  \App\Models\strands  $strands
     * @return void
     */
    public function updated(strands $strands)
    {
        //
    }


    public function deleting(strands $strands)
    {
        
        Cache::forget('allSections');
        Cache::forget('allStudents');
        if($strands->isForceDeleting()){
            $section = $strands->sections()->withTrashed()->get();
            $section->each(function($item){
            $student = $item->students()->withTrashed()->get();
            $student->each(function($st){
                Storage::disk('public')->delete($st->qr_code->path);
                $st->user()->delete();
            });
        });
        }
    }

    /**
     * Handle the strands "deleted" event.
     *
     * @param  \App\Models\strands  $strands
     * @return void
     */
    public function deleted(strands $strands)
    {
        Cache::forget('allSections');
        Cache::forget('allStudents');
        $sections = $strands->sections->collect();
        $sections->each(function($item){
            $item->students()->delete();
        });
        // dd($student);
        $strands->sections()->delete();
    }

    /**
     * Handle the strands "restored" event.
     *
     * @param  \App\Models\strands  $strands
     * @return void
     */
    public function restored(strands $strands)
    {
        
        Cache::forget('allSections');
        Cache::forget('allStudents');
        $strands->sections()->onlyTrashed()->restore();
        $section = $strands->sections->collect();
        $section->each(function($item){
            $item->students()->restore();
        });
    }

    /**
     * Handle the strands "force deleted" event.
     *
     * @param  \App\Models\strands  $strands
     * @return void
     */
    public function forceDeleted(strands $strands)
    {
        //
    }
}
