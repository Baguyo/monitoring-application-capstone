<?php

namespace Database\Seeders;

use App\Models\Strands;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function GuzzleHttp\Promise\each;

class StrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $strands = collect(['STEM','GAS','TVL', 'HUMMS']);

        foreach ($strands as $value) {
            $strand = new Strands();
            $strand->name = $value;
            $strand->save();
        }
    }
}
