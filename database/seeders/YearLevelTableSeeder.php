<?php

namespace Database\Seeders;

use App\Models\YearLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year_level = collect(['7', '8', '9', '10', '11','12']);



        $year_level->each(function($item){
            $yL = new YearLevel();
            $yL->level = $item;
            $yL->save();
        });
    }
}
