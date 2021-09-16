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
            'email' => 'proyectos@seduerey.com',
            'password' => Hash::make('ar0s3Admin{R4z0r}2020{G4l4ct1c4}'),
            'isadmin' => true,
            'biography' => 'A little bit about me'
        ]);
    }
}
