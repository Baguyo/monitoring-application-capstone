<?php

namespace App\Http\Controllers\Admin;

use App\Events\StudentCreation;
use App\Http\Controllers\Controller;
use App\Http\Requests\filterStudentRecords;
use App\Http\Requests\StoreStudent;
use App\Http\Requests\UpdateStudent;
use App\Models\MonitoringRecord;
use App\Models\QrCode as ModelsQrCode;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Student;
use App\Models\User;
use App\Models\YearLevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
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
        
        // $students = Student::withTrashed()
        //                 ->with('user')
        //                 ->with(['section'=> fn($q) => $q->withTrashed()->with(['yearLevel' => fn($s) => $s->withTrashed()])  ])
        //                 ->with(['qr_code'=> fn($q) => $q->withTrashed()])
        //                 ->get();
        $students = DB::table('students')
                        // ->select('students.id', 'students.name', 'students.email')
                        ->join('qr_codes', 'qr_codes.student_id', 'students.id')
                        ->join('sections', 'sections.id', 'students.section_id')    
                        ->join('year_levels', 'year_levels.id', 'sections.year_level_id')
                        ->join('users', 'users.id', 'students.user_id')
                        //SELECT STUDENT DATA
                        ->select('students.id as student_id', 'students.guardian as student_guardian',
                                'students.contact_number as student_contact_number', 'students.address as student_address',
                                'students.user_id as student_user_id', 'students.section_id as student_section_id',
                                'students.deleted_at as student_deleted',
                                //SELECT QR CODE DATA
                         'qr_codes.id as qr_code_id', 'qr_codes.path as qr_code_path',
                                //SELECT USER DATA
                         'users.name as users_name', 'users.email as users_email',
                                //SECTION DATA
                        'sections.name as section_name', 'year_levels.level as year_level' )
                        ->get();

        // dd($students);

        return view('admin.student.index', ['students'=>$students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_year_level = YearLevel::all();
        return view('admin.student.create', ['all_year_level'=> $all_year_level]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudent $request)
    {
        //STORE NEW USER AND ENCRYPT ITS UNIQUE INDENTIFICATION
        //AND EMBED TO QR CODE
        $validatedData = $request->validated();
        $new_user = new User();
        
        $new_user->name = $validatedData['name'];
        $new_user->email = $validatedData['email'];
        $new_user->password = Hash::make($validatedData['password']);
        $new_user->save();

        $student = new Student();
        $student->guardian = $validatedData['guardian'];
        $student->contact_number = $validatedData['contact_number'];
        $student->address = $validatedData['address'];
        $student->user_id = $new_user->id;
        $student->section_id = $validatedData['section'];
        $student->save();

        //SAVE STUDENT QR CODE
        $qr_code = new ModelsQrCode();
        $image = QrCode::format('png')
                ->eye('square')
                ->style('dot', 0.5)
                ->merge('\storage\app\public\defaults\logo.jpg', .3)
                ->errorCorrection('H')
                 ->size(200)
                 ->generate( base64_encode($student->guardian) );
        $output_file = "Qr-code/{$student->user->name}.png";

        $qr_code->code = $student->guardian;
        $qr_code->path = $output_file;
        $qr_code->student()->associate($student)->save();
        Storage::disk('public')->put($output_file,$image);

         event( new StudentCreation($student) );
        return redirect()->route('admin.student.index')->with('status', "New student {$new_user->name} was successfully added" );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }


    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $all_year_level = YearLevel::all();
        return view('admin.student.edit', ['all_year_level'=> $all_year_level, 'student'=>$student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudent $request, Student $student)
    {
        $validatedData = $request->validated();


        /**
         * Updating the student's User Model
         */
        $email = $request->validate([
            'email' => "bail|required|min:3|email|unique:users,email,".$student->user->id,
        ]);

        if(!empty($validatedData['password'])){
            $password = $request->validate([
                'password' => "min:6",
            ]);
            $password = Hash::make($password['password']);
            $student->user->password = $password;
        }        
        $student->user->name = $validatedData['name'];
        $student->user->email = $email['email'];
        $student->user->save();


        /**
         * Updating the student Model
         */
        $student->guardian = $validatedData['guardian'];
        $student->contact_number = $validatedData['contact_number'];
        $student->address = $validatedData['address'];

        //CHECK IF THERE'S SELECTED SECTION
        if(!empty($request->input('section'))){
            $student->section_id = $request->input('section');    
        }

        
        $student->save();

        return redirect()->route('admin.student.index')->with('status', "Student {$student->user->name} was successfully updated" );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        
        return redirect()->route('admin.student.index')->with('status', "Student {$student->user->name} was successfully deleted" );
    }



    public function restore($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->restore();
        
        return redirect()->route('admin.student.index')->with('status', "Student was successfully restored");
    }

    /**
     * Delete permanently the specified resource from storage
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        // Student::where('id', $id)->withTrashed()->forceDelete();
        $student = Student::withTrashed()->with(['qr_code'=>fn($q)=>$q->withTrashed()])->findOrFail($id);
        
        $student->forceDelete();
        return redirect()->route('admin.student.index')->with('status', "Student was deleted permantly");   
    }



    


    public function qr_code($path){
        $qr_code = ModelsQrCode::findOrFail($path);


        // return response()->download( public_path($qr_code->path) );
        return Storage::download($qr_code->path);
        
        
    }

    /**
     * Display scanner page
     */
    public function scan(){
        return view('admin.scan.index');
    }

    /**
     * Accept ajax request
     */
    public function scanCode(Request $request){
        $code = base64_decode($request->input('code'));
        $qr_code = ModelsQrCode::with('student.user')->with('student.section')->firstWhere('code', "$code");
        if(!$qr_code){
            return "not found";
        }else{
            $date = Carbon::now()->timezone('Asia/Singapore')->format('Y-m-d');
            $time = Carbon::now()->timezone('Asia/Singapore')->format('H:i:s');
            // return $qr_code->student->id;
             $monitoring_record = MonitoringRecord::where('student_id', $qr_code->student->id)->where('date',$date )->first();
            if(!$monitoring_record){
                $new_monitoring_record = new MonitoringRecord();
                $new_monitoring_record->date = $date;
                $new_monitoring_record->first_in = $time;
                $new_monitoring_record->student_id = $qr_code->student->id;
                $new_monitoring_record->save();
            }else{
                foreach (MonitoringRecord::$time_status as $value) {
                    if( !isset($monitoring_record->$value) ){
                        $monitoring_record->$value = $time;
                        $monitoring_record->save();
                        break;
                    }
                }
            }
            return $qr_code;
        }
    }

}
