<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@sooqlink.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');
    }
}

