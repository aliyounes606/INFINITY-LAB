<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('Admin');

        $accountant = User::firstOrCreate([
            'name' => 'Accountant User',
            'email' => 'accountant@example.com',
            'password' => bcrypt('12345678'),
        ]);
        $accountant->assignRole('Accountant');
    
      $Material_Manager = User::firstOrCreate([
            'name' => 'Material Manager User',
            'email' => 'MaterialManager@example.com',
            'password' => bcrypt('12345678'),
        ]);
       $Material_Manager->assignRole('Material Manager');
    }
}
