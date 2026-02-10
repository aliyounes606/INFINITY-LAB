<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // نمرر الإيميل فقط في المصفوفة الأولى للبحث
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'], // شرط البحث
            [
                'name' => 'Admin User',
                'password' => bcrypt('12345678'),
            ] // البيانات التي تضاف في حال لم يتم العثور عليه
        );
        $admin->assignRole('Admin');

        $accountant = User::firstOrCreate(
            ['email' => 'accountant@example.com'],
            [
                'name' => 'Accountant User',
                'password' => bcrypt('12345678'),
            ]
        );
        $accountant->assignRole('Accountant');

        $Material_Manager = User::firstOrCreate(
            ['email' => 'MaterialManager@example.com'],
            [
                'name' => 'Material Manager User',
                'password' => bcrypt('12345678'),
            ]
        );
        $Material_Manager->assignRole('Material Manager');
    }
}
