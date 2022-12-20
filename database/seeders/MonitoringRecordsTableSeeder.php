<?php

namespace Database\Seeders;

use App\Models\MonitoringRecord;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonitoringRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();

        $students->each(function($student){
            $MonitoringRecord = MonitoringRecord::factory()->create([
                'student_id' => $student->id,
            ]);
        });
    }
}
