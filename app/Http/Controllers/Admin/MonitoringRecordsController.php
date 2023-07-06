<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterMsRecords;
use App\Models\MonitoringRecord;
use App\Models\Student;
use App\Models\YearLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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

        // $year = 
        //      YearLevel::select(['id','level'])->with('sections')->get();
        // $all_student = Student::with(['user' => function($q){
        //     return $q->orderBy('name', 'asc');
        // }])->get();

        $all_student =  Student::get()->sortBy(function($query){
            return $query->user->name;
         })
         ->all();

        // dd($year);
        // Cache::put('year',$year, 60);
        return view('admin.monitoringRecords.index', ['students'=>$all_student]);
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
        
        // $student_records = MonitoringRecord::with('student.user')->with('student.section')->where('student_id', '=', $validatedDate['student'])
        // ->whereBetween('date', [$validatedDate['date-from'], $validatedDate['date-to']])->get();

        $student_records = DB::table('monitoring_records')
                                ->join('students', 'students.id', 'monitoring_records.student_id')
                                ->join('users', 'users.id', 'students.user_id')
                                ->where('monitoring_records.student_id', '=', $validatedDate['student'])
                                ->whereBetween('date', [$validatedDate['date-from'], $validatedDate['date-to']])
                                ->select('users.name as user_name', 'monitoring_records.date',
                                        'monitoring_records.first_in', 'monitoring_records.first_out',
                                        'monitoring_records.second_in', 'monitoring_records.second_out',
                                        'monitoring_records.third_in', 'monitoring_records.third_out',
                                        'monitoring_records.fourth_in', 'monitoring_records.fourth_out',
                                        'monitoring_records.fifth_in', 'monitoring_records.fifth_out'
                                )
                                ->get();
                                
        $all_student =  Student::get()->sortBy(function($query){
                                    return $query->user->name;
                                 })
                                 ->all();

        return view('admin.monitoringRecords.show', ['students'=>$all_student, 'records'=>$student_records]);
    }


    /*
     * @return \Illuminate\Http\Response
     */
    public function export($id){
      $data = explode('+', $id);

      
      $student_records = MonitoringRecord::with('student.user')->where('student_id', '=', $data[0])
        ->whereBetween('date', [$data[1], $data[2]])->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$student_records[0]->student->user->name}-monitoring-records.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $columns = array('Name', 'Date', 'In', 'Out', 'In', 'Out',  'In', 'Out',  'In', 'Out',  'In', 'Out');
    
        $callback = function() use ($student_records, $columns)

        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
    
            foreach($student_records as $item) {
                fputcsv($file, array(
                    $item->student->user->name, 
                    $item->date,
                    $first_in = MonitoringRecord::convert_hours($item->first_in),
                    $first_out = MonitoringRecord::convert_hours($item->first_out),
                    $second_in = MonitoringRecord::convert_hours($item->second_in),
                    $second_out = MonitoringRecord::convert_hours($item->second_out),
                    $third_in = MonitoringRecord::convert_hours($item->third_in),
                    $third_out = MonitoringRecord::convert_hours($item->third_out),
                    $fourth_in = MonitoringRecord::convert_hours($item->fourth_in),
                    $fourth_out = MonitoringRecord::convert_hours($item->fourth_out),
                    $fifth_in = MonitoringRecord::convert_hours($item->fifth_in),
                    $fifth_out = MonitoringRecord::convert_hours($item->fifth_out),
                ) );
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
      
      
    }
}


// https://stackoverflow.com/questions/32441327/csv-export-in-laravel-5-controller