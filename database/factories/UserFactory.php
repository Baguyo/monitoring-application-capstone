<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }


    /**
     * Indicate that the model's should be an Admin
     * 
     * @return static
     */
    public function admin(){

        return $this->state(function(){
            return [
                'name' => 'dudaydodz',
                'email' => 'dudaydodz@gmail.com',
                'type' => 1
            ];
        } );
    }

    /**
     * Indicate that the model's should be a User
     * 
     * @return static
     */
    public function user(){
        return $this->state(function(){
            return [
                'name' => 'emersonbaguyo',
                'email' => 'emersonbaguyo64@gmail.com',
                'type'=>0
            ];
        });
    }

}
