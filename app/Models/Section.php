<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable =[
        'name',
    ];

    public function strand(){
        return $this->belongsTo('App\Models\Strands');
    }

    public function yearLevel(){
        return $this->belongsTo('App\Models\YearLevel');
    }

    public function students(){
        return $this->hasMany('App\Models\Student');
    }
}
