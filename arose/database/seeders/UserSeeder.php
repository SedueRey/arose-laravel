<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Arose admin',
            'email' => 'instructor@mk.app',
            'password' => Hash::make('123456'),
            'isadmin' => true,
            'biography' => 'A little bit about me'
        ]);
        for ($i=0; $i < 10; $i++) {
            User::create([
                'name' => Str::random(rand(5,20)),
                'email' => 'user'.$i.'@mk.app',
                'password' => Hash::make('123456'),
            ]);
        }
    }
}
