<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@quickreceipt.com',
            'password' => 'password',
            'subscription_status' => 'active',
            'subscription_end' => now()->addYear(),
            'role' => 'admin',
        ]);
    }
}
