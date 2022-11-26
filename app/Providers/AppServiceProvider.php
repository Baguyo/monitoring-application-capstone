<?php

namespace App\Providers;

use App\Models\Section;
use App\Models\Strands;
use App\Models\Student;
use App\Models\YearLevel;
use App\Observers\SectionObserver;
use App\Observers\StrandObserver;
use App\Observers\StudentObserver;
use App\Observers\YearLevelObserver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        YearLevel::observe(YearLevelObserver::class);
        Section::observe(SectionObserver::class);
        Student::observe(StudentObserver::class);
        Strands::observe(StrandObserver::class);
        date_default_timezone_set('Asia/Singapore');
        
        Blade::aliasComponent('components.page-header', 'pageHeader');
    }
}
