<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Strands extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable =[
        'name',
    ];

    public function sections(){
        return $this->hasMany("App\Models\Section");
    }
}
