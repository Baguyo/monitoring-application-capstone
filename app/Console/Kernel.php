<?php

namespace App\Console;

use App\Models\MonitoringRecord;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use SmsGateway24\SmsGateway24;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function(){
            $date = Carbon::now()->timezone('Asia/Singapore')->format('Y-m-d');
            $all_monitoring_today = MonitoringRecord::with('student.user')->where('date', '=', $date)->get();
            $all_monitoring_today->each(function($monitoring){

                $message = " Full report of {$monitoring->student->user->name} monitoring records as of today";
                $message = $message . " {$monitoring->first_in} - {$monitoring->first_out} \n" ;
                $message = $message . " {$monitoring->second_in} - {$monitoring->second_out} \n" ;
                $message = $message . " {$monitoring->third_in} - {$monitoring->third_out} \n" ;
                $message = $message . " {$monitoring->fourth_in} - {$monitoring->fourth_out} \n" ;
                $message = $message . " {$monitoring->fifth_in} - {$monitoring->fifth_out} \n" ;

                $message = $message . "Unbalanced monitoring report cause of no internet connection";

                $baseUrl = "https://smsgateway24.com";
                $endpoint = "/getdata/addsms";
                $url = $baseUrl.$endpoint;
                $paramsArr = [];

                /* Required fields */
                $paramsArr['token'] = env('SMS_GATE_AWAY_API'); // put here your token
                $paramsArr['sendto'] = "{$monitoring->student->contact_number}";  // our Support number :) Text us to WhatsApp Or Telegram if you need help!
                $paramsArr['body'] = $message; // also you can send long messages
                $paramsArr['device_id'] = env('SMS_GATE_AWAY_DEVICE_ID');
                $paramsArr['sim'] = env('SMS_GATE_AWAY_SIM');;  // 0 or 1. try first 0.

                /* Optional fields */
                // $paramsArr['timetosend'] = "2021-08-01 12:00";  // When SMS should go
                // $paramsArr['customerid'] = "19921"; //  any ID from your internal system.  Then you can use this feature in reports
                $paramsArr['urgent'] = "1";

                $ch = curl_init();

                curl_setopt($ch, \CURLOPT_URL, $url);
                curl_setopt($ch, \CURLOPT_POST, 1);
                curl_setopt($ch, \CURLOPT_POSTFIELDS, $paramsArr);
                curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close($ch);

                /* Example of good answer: */
                /* {"error":0,"sms_id":22074938,"message":"Sms has been saved successfully"} */

                /* if you prefer array: */
                $responceArr  = json_decode($server_output);

                // info($monitoring);
                // $smsGateway = new SmsGateway24(env('SMS_GATE_AWAY_API'));

                // $to = "+63".$monitoring->student->contact_number;  // Also this is our Support number. Text us to WhatsApp
                // $deviceId = env('SMS_GATE_AWAY_DEVICE_ID'); // get it in your profile after app installation on your android
                // $customerid = null; // Optional. your internal customer ID. 
                // $urgent = null; // Optional. 1 or 0 to make sms Urgent.  
                // $sim=env('SMS_GATE_AWAY_SIM');  // 0 or 1. For Dual SIM devices. (default sim = 0)
                // $customerid=null; // your internal customer ID. 

                // //CONTRACTING THE MESSAGE
                // $message = " Full report of {$monitoring->student->user->name} monitoring records as of today";
                // $message = $message . " {$monitoring->first_in} - {$monitoring->first_out} \n" ;
                // $message = $message . " {$monitoring->second_in} - {$monitoring->second_out} \n" ;
                // $message = $message . " {$monitoring->third_in} - {$monitoring->third_out} \n" ;
                // $message = $message . " {$monitoring->fourth_in} - {$monitoring->fourth_out} \n" ;
                // $message = $message . " {$monitoring->fifth_in} - {$monitoring->fifth_out} \n" ;

                // $message = $message . "Unbalanced monitoring report cause of no internet connection";
                // $smsGateway->addSms($to, $message, $deviceId, $customerid, $sim, $customerid, $urgent);

                
            });
        })->daily()->timezone('Asia/Singapore')->at('11:52');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
