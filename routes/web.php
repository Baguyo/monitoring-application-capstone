<?php

use App\Mail\NotifyStudentCreation;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo', function(){
    return view('demo.index');
});




// Route::get('email', function(){
//     $student = Student::find(1);
//     return new NotifyStudentCreation($student);
// });









Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=> 'auth'], function(){

    // Route::get('user_dashboard', [App\Http\Controllers\User\DashboardController::class, 'index']);

    //ROUTE GROUP FOR ADMIN
    Route::middleware(['user_access:admin'])->group(function(){

        Route::get('admin_dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::prefix('admin')->group(function(){

            //STRANDS
            Route::as('admin')->resource('strand', App\Http\Controllers\Admin\StrandsController::class);
            //STRAND EXTRA ACTION
            Route::post('strand/{strand}/restore', [App\Http\Controllers\Admin\StrandsController::class, 'restore'])->name('admin.strand.restore');
            Route::post('strand/{strand}/fd', [App\Http\Controllers\Admin\StrandsController::class, 'forceDelete'])->name('admin.strand.forceDelete');

            //YEAR 
            Route::as('admin')->resource('year', App\Http\Controllers\Admin\YearLevelController::class);
            //YEAR EXTRA ACTION
            Route::post('year/{year}/restore', [App\Http\Controllers\Admin\YearLevelController::class, 'restore'])->name('admin.year.restore');
            Route::post('year/{year}/fd', [App\Http\Controllers\Admin\YearLevelController::class, 'forceDelete'])->name('admin.year.forceDelete');


            //SECTION
            Route::as('admin')->resource('section', App\Http\Controllers\Admin\SectionController::class);
            //SECTION EXTRA ACTION
            Route::post('section/{section}/r', [App\Http\Controllers\Admin\SectionController::class, 'restore'])->name('admin.section.restore');
            Route::post('section/{section}/fd', [App\Http\Controllers\Admin\SectionController::class, 'forceDelete'])->name('admin.section.forceDelete');


            //STUDENT
            Route::as('admin')->resource('student', App\Http\Controllers\Admin\StudentController::class);
            Route::get('students/record', [App\Http\Controllers\Admin\StudentController::class, 'showRecords'])->name('admin.student_records.show');
            //STUDENT EXTRA ACTION
            Route::post('student/{student}/r', [App\Http\Controllers\Admin\StudentController::class, 'restore'])->name('admin.student.restore');
            Route::post('student/{student}/fd', [App\Http\Controllers\Admin\StudentController::class, 'forceDelete'])->name('admin.student.forceDelete');
            Route::post('student/{path}/download', [App\Http\Controllers\Admin\StudentController::class, 'qr_code'])->name('admin.student.qr_code');


            //ADMINISTRATOR
            Route::as('admin')->resource('users', App\Http\Controllers\Admin\AdministratorController::class);

            //SCAN QR CODE
            Route::get('scan', [App\Http\Controllers\Admin\StudentController::class, 'scan'])->name('admin.scan');
            Route::post('scan', [App\Http\Controllers\Admin\StudentController::class, 'scanCode'])->name('admin.scanCode');


            //MONITORING RECORDS
            Route::get('msrecord', [App\Http\Controllers\Admin\MonitoringRecordsController::class, 'index'])->name('admin.records.index');
            Route::get('msrecordshow', [App\Http\Controllers\Admin\MonitoringRecordsController::class, 'show'])->name('admin.records.show');
            Route::get('msrecordexport/{sid}', [App\Http\Controllers\Admin\MonitoringRecordsController::class, 'export'])->name('admin.records.export');


            //FETCH LEVEL'S SECTIONS
            Route::get('/get-sections/{level}', [App\Http\Controllers\Admin\YearLevelController::class, 'getSection'])->name('admin.levels.section');
            Route::get('/get-student/{section}', [App\Http\Controllers\Admin\SectionController::class, 'getStudents'])->name('admin.section.student');
        });

        
        

    });


    //ROUTE GROUP FOR USER
    Route::middleware(['user_access:user'])->group(function(){

        Route::get('user', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');

        Route::prefix('user')->group(function(){

            //PROFILE
            Route::as('user')->resource('profile', App\Http\Controllers\User\ProfileController::class)->only(['update','edit', 'show']);

            //MS RECORDS
            Route::get('msrecord', [App\Http\Controllers\User\MonitoringRecordsController::class, 'index'])->name('user.records.index');
            Route::get('msrecordshow', [App\Http\Controllers\User\MonitoringRecordsController::class, 'show'])->name('user.records.show');
            Route::get('msrecordexport/{sid}', [App\Http\Controllers\User\MonitoringRecordsController::class, 'export'])->name('user.records.export');

            //CONTACT US
            Route::get('contact', [App\Http\Controllers\User\ContactUsController::class, 'create'])->name('user.contact.create');
            Route::post('contact', [App\Http\Controllers\User\ContactUsController::class, 'messageSend'])->name('user.contact.send');
            
            
        });

    });

    // FIX DATATABLE VITE
    // https://stackoverflow.com/questions/73044119/how-to-use-datatables-with-laravel-vite



});



Auth::routes();

