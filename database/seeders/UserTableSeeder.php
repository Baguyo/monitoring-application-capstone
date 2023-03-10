<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = max( (int)$this->command->ask('How many user you want to create? ', 10), 1 );

        User::factory()->admin()->create();
        User::factory()->user()->create();
        User::factory()->delete_user()->create();

        User::factory()->count($userCount)->create();
    }
}
