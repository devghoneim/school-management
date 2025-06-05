<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Mohamed Ghoneim',
            'email'=>'mg@gmail.com',
            'password'=>'123456789'
        ]);
    }
}
