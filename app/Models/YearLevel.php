<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class YearLevel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'level'
    ];

    public function sections(){
        return $this->hasMany('App\Models\Section');
    }


    public static function boot(){
        parent::boot();

        // static::restored(function(YearLevel $yearLevel){
        //     dd("pota");
        // });
    }

}
