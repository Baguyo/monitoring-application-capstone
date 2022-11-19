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
    ];

    public function student(){
        return $this->belongsTo('App\Models\Student');
    }
}
