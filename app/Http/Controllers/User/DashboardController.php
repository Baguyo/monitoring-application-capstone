<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MonitoringRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index(){

        $student_id = Auth::user()->student->id;
        
        $number_monitoring_records = MonitoringRecord::where('student_id', $student_id)->count();

        return view('user.dashboard', ['total_monitoring_records' => $number_monitoring_records]);
    }

}
