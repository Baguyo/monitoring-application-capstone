<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MonitoringRecord;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_access:user');
    }

    public function index(){

        if(!isset(Auth::user()->student->id)){
            abort(500);
        }

        $number_monitoring_records = MonitoringRecord::where('student_id', Auth::user()->student->id)->count();

        return view('user.dashboard', ['total_monitoring_records' => $number_monitoring_records]);
    }

}
