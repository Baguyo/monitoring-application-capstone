<?php

namespace App\Console;

use App\Models\MonitoringRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
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

        $schedule->call(function () {

            $baseUrl = "https://smsgateway24.com";
            $endpoint = "/getdata/addalotofsms";
            $url = $baseUrl . $endpoint;
            $paramsArr = [];


            /* Required fields */
            $paramsArr['token'] = env('SMS_GATE_AWAY_API');
            $paramsArr['smsdata'] = [
                // [
                //     "sendto" => "+49 157 52982212",
                //     "body" => "test message 1",
                //     "device_id" => "260",
                //     "sim" => 0,
                //     "timetosend" => "2019-07-01 23:50:00",
                //     "urgent" => "1"

                // ], [
                //     "sendto" => "+49 157 52982212",
                //     "body" => "test message 2 ",
                //     "device_id" => "260",
                //     "sim" => 0,
                //     "timetosend" => "2019-07-01 23:50:00",
                //     "urgent" => "1"
                // ]
            ];


            $date = Carbon::now()->timezone('Asia/Singapore')->format('Y-m-d');
            $all_monitoring_today = MonitoringRecord::with('student.user')->where('date', '=', $date)->get();
            $all_monitoring_today->each(function ($monitoring) use(&$paramsArr, $date) {

                
                //CONVERTING TIME TO 12 HOURS FORMAT
                $first_in = MonitoringRecord::convert_hours($monitoring->first_in);
                $first_out = MonitoringRecord::convert_hours($monitoring->first_out);
                $second_in = MonitoringRecord::convert_hours($monitoring->second_in);
                $second_out = MonitoringRecord::convert_hours($monitoring->second_out);
                $third_in = MonitoringRecord::convert_hours($monitoring->third_in);
                $third_out = MonitoringRecord::convert_hours($monitoring->third_out);
                $fourth_in = MonitoringRecord::convert_hours($monitoring->fourth_in);
                $fourth_out = MonitoringRecord::convert_hours($monitoring->fourth_out);
                $fifth_in = MonitoringRecord::convert_hours($monitoring->fifth_in);
                $fifth_out = MonitoringRecord::convert_hours($monitoring->fifth_out);
                


                $message = " Full report of {$monitoring->student->user->name} monitoring records as of today. \n";
                $message = $message . " {$first_in} " . " - " . " {$first_out} \n";
                $message = $message . " {$second_in}" . " - " . " {$second_out} \n";
                $message = $message . " {$third_in} " . " - " . "{$third_out} \n";
                $message = $message . " {$fourth_in}" . " - " . " {$fourth_out} \n";
                $message = $message . " {$fifth_in} " . " - " . "{$fifth_out} \n";

                $message = $message . "Unbalanced monitoring report cause of no internet connection or no electricity at the School campus.";

                $sms_array = [
                    "sendto" => "+63{$monitoring->student->contact_number}",
                    "body" => $message,
                    "device_id" => env('SMS_GATE_AWAY_DEVICE_ID'),
                    "sim" => env('SMS_GATE_AWAY_SIM'),
                    // "timetosend" => $date . env('TIME_TO_SEND'),
                    "urgent" => "1"
                ];
                
                $paramsArr['smsdata'][] = $sms_array;

                // ========================================================= old =================================
                // $baseUrl = "https://smsgateway24.com";
                // $endpoint = "/getdata/addsms";
                // $url = $baseUrl.$endpoint;
                // $paramsArr = [];

                // /* Required fields */
                // $paramsArr['token'] = env('SMS_GATE_AWAY_API'); // put here your token
                // $paramsArr['sendto'] = "{$monitoring->student->contact_number}";  // our Support number :) Text us to WhatsApp Or Telegram if you need help!
                // $paramsArr['body'] = $message; // also you can send long messages
                // $paramsArr['device_id'] = env('SMS_GATE_AWAY_DEVICE_ID');
                // $paramsArr['sim'] = env('SMS_GATE_AWAY_SIM');;  // 0 or 1. try first 0.

                // /* Optional fields */
                // // $paramsArr['timetosend'] = "2021-08-01 12:00";  // When SMS should go
                // // $paramsArr['customerid'] = "19921"; //  any ID from your internal system.  Then you can use this feature in reports
                // $paramsArr['urgent'] = "1";

                // $ch = curl_init();

                // curl_setopt($ch, \CURLOPT_URL, $url);
                // curl_setopt($ch, \CURLOPT_POST, 1);
                // curl_setopt($ch, \CURLOPT_POSTFIELDS, $paramsArr);
                // curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
                // $server_output = curl_exec($ch);
                // curl_close($ch);


                // $responceArr  = json_decode($server_output);
            });

            // var_dump($paramsArr);
            

            $json = json_encode($paramsArr);

            $arr['datajson'] = $json;


            $ch = curl_init();

            curl_setopt($ch, \CURLOPT_URL, $url);
            curl_setopt($ch, \CURLOPT_POST, 1);
            curl_setopt($ch, \CURLOPT_POSTFIELDS, $arr);
            curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);
            $responceArr = json_decode($server_output);
            echo $server_output;
        })->daily()->timezone('Asia/Singapore')->at(env('TIME_TO_SEND'));

        $schedule->call(function(){
            
            
            $year = (int)Carbon::now()->timezone('Asia/Singapore')->format('Y');

            $all_users = User::where('type', 0)->get();
            $all_users->each(function($user) use($year) {

                if( $year - $user->created_at->year >= 3 ){
                    // var_dump($user->student->qr_code->path);
                    Storage::disk('public')->delete($user->student->qr_code->path);
                    if($user->img_path){
                        Storage::disk('public')->delete($user->img_path);
                    }
                    $user->delete();

                    // var_dump('reach equal or greater than 3');
                }

            });

            

        })->everyMinute();
    }



    

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
