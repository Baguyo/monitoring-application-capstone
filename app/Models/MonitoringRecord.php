<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringRecord extends Model
{
    use HasFactory;

    static public $time_status = [
        'first_in',
        'first_out',
        'second_in',
        'second_out',
        'third_in',
        'third_out',
        'fourth_in',
        'fourth_out',
        'fifth_in',
        'fifth_out',
    ];

    public function student(){
        return $this->belongsTo('App\Models\Student');
    }

    public static function convert_hours($value){
        if($value){
            return date('h:i:s a', strtotime($value));
        }else{
            return '';
        }
    }
}
