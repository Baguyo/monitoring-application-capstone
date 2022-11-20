<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Student;
use App\Models\YearLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        if( $this->command->confirm( "Are you sure you want to refresh the database?", true ) ){
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');

            Storage::disk('public')->deleteDirectory('Qr-code');
            Storage::disk('public')->deleteDirectory('avatars');
            

            $this->call([
                UserTableSeeder::class,
                StrandTableSeeder::class,
                YearLevelTableSeeder::class,
                SectionTableSeeder::class,
                StudentTableSeeder::class,
            ]);

        }

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
    }
}
