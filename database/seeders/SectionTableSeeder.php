<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Strands;
use App\Models\YearLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count_per_level = (int)$this->command->ask( "How many sections per grade level you want to create?", 5 );

        $yL = YearLevel::all();
        $strand = Strands::all();

        $yL->each(function($item) use($count_per_level, $strand) {
            Section::factory()->count($count_per_level)->make()->each(function($section) use($item, $strand) {
                $section->year_level_id = $item->id;
                $section->strands_id = $strand->random()->id;
                $section->save();
            });
        });
    }
}
