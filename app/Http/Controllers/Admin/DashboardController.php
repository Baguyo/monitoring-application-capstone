<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonitoringRecord;
use App\Models\Section;
use App\Models\User;
use App\Models\YearLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_access:admin');
    }

    public function index(){

        // $total_students = User::where('type', '=', '0')->count();
        // $total_students = Cache::remember('total_students', 60, function(){
        //    return User::where('type', '=', '0')->count();
        // });

        // $total_year_level = Cache::remember('total_year_level', 60, function(){
        //     return YearLevel::count();
        // });
        
        // $total_sections = Cache::remember('total_sections', 60, function(){
        //     return Section::count();
        // });

        // $total_admin = Cache::remember('total_admin', 60, function(){
        //     return User::where('type', '=', '1')->count();
        // }); 

        // $total_monitoring_record = Cache::remember('total_records', 60, function(){
        //     return MonitoringRecord::count();
        // });

        $total_students = User::where('type', '=', '0')->count();
        $total_year_level = YearLevel::count();
        $total_sections = Section::count();
        $total_admin = User::where('type', '=', '1')->count();
        $total_monitoring_record = MonitoringRecord::count();

        return view('admin.dashboard', [
            'total_students'=> $total_students, 
            'total_year_level'=>$total_year_level,
            'total_sections' => $total_sections,
            'total_admin' => $total_admin,
            'total_monitoring_records' => $total_monitoring_record,
            
        ]);
    }
}
