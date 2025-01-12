<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'=>'eeic',
            'email'=>'eeic@entlaqa.com',
            'password'=>Hash::make('Eeic@2024#Z')
        ]);
        //*Password at mailgun @2025Certificate
    }
}
