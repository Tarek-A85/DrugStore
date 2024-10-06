<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Tarek',
            'email'=>'tarek@gmail.com',
            'phone_number'=>'0991561209',
            'password'=>bcrypt('12345678'),
            'is_admin'=>true,
        ]);
    }
}
