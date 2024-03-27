<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        $super_admin = User::updateOrCreate(
            [
                'email' => 'admin@gmail.com'
            ],
            [
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('rahasia123')
            ]
        );
        $super_admin->assignRole('super admin');

        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                // 'name' => fake()->name(),
                // 'email' => fake()->unique()->safeEmail(),
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('rahasia123'),
                'remember_token' => Str::random(10),
            ]);

            $user->assignRole('user');
        }
    }
}