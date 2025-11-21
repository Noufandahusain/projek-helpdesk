<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
        'name' => 'admin',
        'email' => 'admin@pens.ac.id',
        'password' => bcrypt('admin'),
        'role' => 'admin'
    ]);
    }
}
