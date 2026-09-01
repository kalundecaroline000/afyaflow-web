<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'doctor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'nurse', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'receptionist', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'billing_officer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'patient', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}