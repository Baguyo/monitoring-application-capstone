<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterMsRecords;
use App\Models\MonitoringRecord;
use App\Models\Student;
use App\Models\YearLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class MonitoringRecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_access:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $year = 
             YearLevel::select(['id','level'])->with('sections')->get();
        

        // dd($year);
        // Cache::put('year',$year, 60);
        return view('admin.monitoringRecords.index', ['year'=> $year]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FilterMsRecords $request)
    {
        $validatedDate = $request->validated();
        // $student = Student::findOrFail($validatedDate['student']);
        
        $student_records = MonitoringRecord::with('student.user')->with('student.section')->where('student_id', '=', $validatedDate['student'])
        ->whereBetween('date', [$validatedDate['date-from'], $validatedDate['date-to']])->get();
        

        $year = YearLevel::with('sections')->get();
        return view('admin.monitoringRecords.show', ['year'=>$year, 'records'=>$student_records]);
    }


    /*
     * @return \Illuminate\Http\Response
     */
    public function export($id){
      $data = explode('+', $id);

      $student_records = MonitoringRecord::with('student.user')->with('student.section')->where('student_id', '=', $data[0])
        ->whereBetween('date', [$data[1], $data[2]])->get();

    
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=monitoring-records.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $columns = array('Name', 'Section', 'Date', 'In', 'Out', 'In', 'Out');
    
        $callback = function() use ($student_records, $columns)

        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
    
            foreach($student_records as $item) {
                fputcsv($file, array(
                    $item->student->user->name, 
                    $item->student->section->name, 
                    $item->date,
                    ($item->first_in) ? date('h:i:A', strtotime($item->first_in)) : "",
                    ($item->first_out) ? date('h:i:A', strtotime($item->first_out)) : "",
                    ($item->second_in) ? date('h:i:A', strtotime($item->second_in)) : "",
                    ($item->second_out) ? date('h:i:A', strtotime($item->second_out)) : "",
                ) );
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
      
      
    }
}


// https://stackoverflow.com/questions/32441327/csv-export-in-laravel-5-controller