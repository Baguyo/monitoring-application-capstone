<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    use HasFactory;
    

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function section(){
        return $this->belongsTo('App\Models\Section');
    }

    public function qr_code(){
        return $this->hasOne('App\Models\QrCode');
    }

    public function monitoringRecord(){
        return $this->hasMany('App\Models\MonitoringRecord');
    }
}
