<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminCreation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdministrator;
use App\Http\Requests\UpdateAdministrator;
use App\Models\MonitoringRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdministratorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_access:admin');
        $this->authorizeResource(User::class, 'user');
    }



 


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit( User $user)
    {
        $time_to_send = $_ENV['TIME_TO_SEND'];
        return view('admin.administrator.edit', ['admin' => $user, 'time_to_send' => $time_to_send]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdministrator $request, User $user)
    {
     

        $validatedData = $request->validated();

        
        if(!empty($validatedData['password'])){
            $password = $request->validate([
                'password' => "min:6",
            ]);
            $password = Hash::make($password['password']);
            $user->update([
                'password' => $password,
            ]);
        }

        if(!empty($validatedData['time'])){
            file_put_contents(app()->environmentFilePath(), str_replace(
                'TIME_TO_SEND' . '=' . env('TIME_TO_SEND'),
                'TIME_TO_SEND' . '=' . $validatedData['time'],
                file_get_contents(app()->environmentFilePath())
            ));
            
        }
        return redirect()->back()->with('status', "Your profile was successfully updated" );

    }
    
    public function brownOut()
    {
        $date = Carbon::now()->timezone('Asia/Singapore')->format('Y-m-d');
        $monitoring_record = MonitoringRecord::where('date', $date)->get();

        if ($monitoring_record) {
            $monitoring_record->each(
                function ($record) {
                    foreach (MonitoringRecord::$time_status as $value) {
                        if (!isset($record->$value)) {
                            $record->$value = "04:00:00";
                            $record->save();
                            break;
                        }
                    }
                }
            );
            return redirect()->back()->with('status', " Brownout to all monitoring records as of today has been successfully indicated. ");
        }
    }

    
    
}
