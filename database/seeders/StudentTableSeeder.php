<?php

namespace Database\Seeders;

use App\Models\QrCode;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode as FacadesQrCode;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $all_students_user = User::where('type', '=', '0')->get();
        $all_sections = Section::all();

        $all_students_user->each(function($item) use($all_sections) {
            $student =  Student::factory()->create([
                'user_id' => $item->id,
                'section_id'=>$all_sections->random()->id,
            ]);
            
            $qr_code = new QrCode();
            $image = FacadesQrCode::format('png')
                    ->eye('square')
                    ->style('dot', 0.5)
                    ->merge('\storage\app\public\defaults\logo.jpg', .3)
                    ->errorCorrection('H')
                    ->size(200)
                    ->generate( base64_encode($student->guardian) );
            $output_file = "Qr-code/{$student->user->name}.png";


            $qr_code->code = $student->guardian;
            $qr_code->path = $output_file;
            $qr_code->student()->associate($student)->save();
            Storage::disk('public')->put($output_file,$image);

        });

        
    }
}
