<?php

namespace App\Http\Controllers\Admin;

use App\Events\StudentCreation;
use App\Http\Controllers\Controller;
use App\Http\Requests\filterStudentRecords;
use App\Http\Requests\StoreStudent;
use App\Http\Requests\UpdateStudent;
use App\Models\MonitoringRecord;
use App\Models\QrCode as ModelsQrCode;
use App\Models\Strands;
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
use SmsGateway24\SmsGateway24;

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

        $students = DB::table('students')
            ->select('students.id', 'students.name', 'students.email')
            ->join('qr_codes', 'qr_codes.student_id', 'students.id')
            ->join('users', 'users.id', 'students.user_id')
            //SELECT STUDENT DATA
            ->select(
                'students.id as student_id',
                'students.student_number as student_number',
                'students.contact_number as student_contact_number',
                'students.user_id as student_user_id',
                'students.deleted_at as student_deleted',
                //SELECT QR CODE DATA
                'qr_codes.id as qr_code_id',
                'qr_codes.path as qr_code_path',
                //SELECT USER DATA
                'users.name as users_name',
                'users.email as users_email',
                'users.img_path as user_image',
            )
            ->get();




        return view('admin.student.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudent $request)
    {
        $validatedData = $request->validated();

        $new_user = new User();
        $new_user->name = $validatedData['name'];
        $new_user->email = $validatedData['email'];
        //SAVING IMAGE 
        if ($request->hasFile('image')) {
            $img_path = $request->file('image')->store('avatars');
            $new_user->img_path = $img_path;
        }
        $new_user->password = Hash::make($validatedData['password']);

        $new_user->save();

        //CREATING STUDENT
        $student = new Student();
        $student->student_number = $validatedData['student_number'];
        $student->contact_number = $validatedData['contact_number'];
        $student->user_id = $new_user->id;
        $student->save();

        //CREATING STUDENT QR CODE
        $qr_code = new ModelsQrCode();
        $image = QrCode::format('png')
            ->eye('square')
            ->eyeColor(0, 0, 17, 255, 0, 0, 0)
            ->eyeColor(1, 0, 17, 255, 0, 0, 0)
            ->eyeColor(2, 255, 17, 0, 0, 0, 0)
            ->backgroundColor(255, 255, 255)
            ->margin(2)
            ->merge('/storage/app/public/defaults/logo.jpg', .3)
            ->errorCorrection('H')
            ->size(250)
            ->encoding('UTF-8')
            ->generate(base64_encode($student->student_number));
        $output_file = "Qr-code/{$student->user->name}-{$student->student_number}.png";
        $qr_code->code = $student->student_number;
        $qr_code->path = $output_file;
        $qr_code->student()->associate($student)->save();
        Storage::disk('public')->put($output_file, $image);

        event(new StudentCreation($student, $validatedData['password']));
        return redirect()->route('admin.student.index')->with('status', "New student {$new_user->name} was successfully added");
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
        return view('admin.student.edit', ['student' => $student]);
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
            'email' => "bail|required|min:3|email|unique:users,email," . $student->user->id,
        ]);

        if (!empty($validatedData['password'])) {
            $password = $request->validate([
                'password' => "min:6",
            ]);
            $password = Hash::make($password['password']);
            $student->user->password = $password;
        }
        $student->user->name = $validatedData['name'];
        $student->user->email = $email['email'];
        //SAVING IMAGE 
        if ($request->hasFile('image')) {
            $img_path = $request->file('image')->store('avatars');
            if (isset($student->user->img_path)) {
                Storage::delete($student->user->img_path);
                $student->user->img_path = $img_path;
            } else {
                $student->user->img_path = $img_path;
            }
        }
        $student->user->save();


        /**
         * Updating the student Model
         */

        $student_number = $request->validate([
            'student_number' => "bail|required|min:3|unique:students,student_number," . $student->id,
        ]);

        if ($student->student_number !== $student_number['student_number']) {
            if ($student->qr_code()) {
                Storage::disk('public')->delete($student->qr_code->path);
            }
            $student->qr_code->code = $student_number['student_number'];
            $qr_code = new ModelsQrCode();
            $image = QrCode::format('png')
                ->eye('square')
                ->eyeColor(0, 0, 17, 255, 0, 0, 0)
                ->eyeColor(1, 0, 17, 255, 0, 0, 0)
                ->eyeColor(2, 255, 17, 0, 0, 0, 0)
                ->backgroundColor(255, 255, 255)
                ->margin(2)
                ->merge('/storage/app/public/defaults/logo.jpg', .3)
                ->errorCorrection('H')
                ->size(250)
                ->encoding('UTF-8')
                ->generate(base64_encode($student_number['student_number']));
            $output_file = "Qr-code/{$student->user->name}-{$student->student_number}.png";
            $student->qr_code->path = $output_file;
            $student->qr_code->save();
            Storage::disk('public')->put($output_file, $image);
            
            // iAC2H(UJTOtf
        }


        $student->student_number = $student_number['student_number'];
        $student->contact_number = $validatedData['contact_number'];
        $student->save();

        return redirect()->route('admin.student.index')->with('status', "Student {$student->user->name} was successfully updated");
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $student = Student::findOrFail($id);
    //     $student->delete();

    //     return redirect()->route('admin.student.index')->with('status', "Student {$student->user->name} was successfully deleted" );
    // }



    // public function restore($id)
    // {
    //     $student = Student::withTrashed()->findOrFail($id);
    //     $student->restore();

    //     return redirect()->route('admin.student.index')->with('status', "Student was successfully restored");
    // }

    /**
     * Delete permanently the specified resource from storage
     */
    // public function forceDelete($id)
    // {
    //     // Student::where('id', $id)->withTrashed()->forceDelete();
    //     $student = Student::withTrashed()->with(['qr_code'=>fn($q)=>$q->withTrashed()])->findOrFail($id);

    //     $student->forceDelete();
    //     return redirect()->route('admin.student.index')->with('status', "Student was deleted permantly");   
    // }






    public function qr_code($path)
    {
        $qr_code = ModelsQrCode::findOrFail($path);


        // return response()->download( public_path($qr_code->path) );
        return Storage::download($qr_code->path);
    }

    /**
     * Display scanner page
     */
    public function scan()
    {
        return view('admin.scan.index');
    }

    /**
     * Accept ajax request
     */
    public function scanCode(Request $request)
    {

        $smsGateway = new SmsGateway24(env('SMS_GATE_AWAY_API'));


        $code = base64_decode($request->input('code'));
        $qr_code = ModelsQrCode::with('student.user')->firstWhere('code', "$code");


        if (!$qr_code) {
            return "not found";
        } else {
            $date = Carbon::now()->timezone('Asia/Singapore')->format('Y-m-d');
            $time = Carbon::now()->timezone('Asia/Singapore')->format('H:i:s');

            $time_ideal_format = Carbon::now()->timezone('Asia/Singapore')->format('h:i:s:A');

            $to = "+63" . $qr_code->student->contact_number;  // Also this is our Support number. Text us to WhatsApp
            $deviceId = env('SMS_GATE_AWAY_DEVICE_ID'); // get it in your profile after app installation on your android
            $customerid = null; // Optional. your internal customer ID. 
            $urgent = null; // Optional. 1 or 0 to make sms Urgent.  
            $sim = env('SMS_GATE_AWAY_SIM');  // 0 or 1. For Dual SIM devices. (default sim = 0)
            $customerid = null; // your internal customer ID. 


            // return $qr_code->student->id;
            $monitoring_record = MonitoringRecord::where('student_id', $qr_code->student->id)->where('date', $date)->first();
            if (!$monitoring_record) {
                $new_monitoring_record = new MonitoringRecord();
                $new_monitoring_record->date = $date;
                $new_monitoring_record->first_in = $time;
                $new_monitoring_record->student_id = $qr_code->student->id;
                $new_monitoring_record->save();

                //CONTRACTING THE MESSAGE
                // $message = "{$qr_code->student->user->name} has safely arrived at Fullbright College Inc. ";
                // $message = $message . "Date: {$date}, Time: {$time_ideal_format}. ";
                // $message = $message . " ( {$qr_code->student->user->name} ay ligtas na nakarating sa Fullbright College Inc. ";
                // $message = $message . "Petsa: {$date} , Oras: {$time_ideal_format} )" ;
                // $smsGateway->addSms($to, $message, $deviceId, $customerid, $sim, $customerid, $urgent);
            } else {
                foreach (MonitoringRecord::$time_status as $value) {
                    if (!isset($monitoring_record->$value)) {
                        $monitoring_record->$value = $time;
                        $monitoring_record->save();
                        break;
                    }

                    //     if($value === 'first_out' || $value === 'second_out'){
                    //         $message = "{$qr_code->student->user->name} has left Fullbright College Inc. ";
                    //         $message = $message . "Date: {$date}, Time: {$time_ideal_format}. ";
                    //         $message = $message . " ( {$qr_code->student->user->name} ay umalis na sa Fullbright College Inc. ";
                    //         $message = $message . "Petsa: {$date} , Oras: {$time_ideal_format} )" ;
                    //         $smsGateway->addSms($to, $message, $deviceId, $customerid, $sim, $customerid, $urgent);
                    //     }elseif($value === 'first_in' || $value === 'second_in'){
                    //         $message = "{$qr_code->student->user->name} has safely arrived at Fullbright College Inc. ";
                    //         $message = $message . "Date: {$date}, Time: {$time_ideal_format}. ";
                    //         $message = $message . " ( {$qr_code->student->user->name} ay ligtas na nakarating sa Fullbright College Inc. ";
                    //         $message = $message . "Petsa: {$date} , Oras: {$time_ideal_format} )" ;
                    //         $smsGateway->addSms($to, $message, $deviceId, $customerid, $sim, $customerid, $urgent);
                    //     }else{
                    //         $message = "{$qr_code->student->user->name} successfully scan his/her Qr code at Fullbright College Inc. ";
                    //         $message = $message . "Date: {$date}, Time: {$time_ideal_format}. ";
                    //         $message = $message . " ( {$qr_code->student->user->name} ay matagumpay na na scan ang kanyang Qr code sa Fullbright College Inc. ";
                    //         $message = $message . "Petsa: {$date} , Oras: {$time_ideal_format} )" ;
                    //         $smsGateway->addSms($to, $message, $deviceId, $customerid, $sim, $customerid, $urgent);
                    //     }
                    //     break;
                    // }elseif($value === 'second_out' && isset($monitoring_record->$value)){
                    //     $message = "{$qr_code->student->user->name} successfully scan his/her Qr code at Fullbright College Inc. ";
                    //     $message = $message . "Date: {$date}, Time: {$time_ideal_format}. ";
                    //     $message = $message . " ( {$qr_code->student->user->name} ay matagumpay na na scan ang kanyang Qr code sa Fullbright College Inc. ";
                    //     $message = $message . "Petsa: {$date} , Oras: {$time_ideal_format} )" ;
                    //     $smsGateway->addSms($to, $message, $deviceId, $customerid, $sim, $customerid, $urgent);

                }
            }
            return $qr_code;
        }
    }
}
