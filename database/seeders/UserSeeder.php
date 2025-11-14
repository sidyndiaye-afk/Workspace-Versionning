<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@levell.local'],
            [
                'name' => 'Admin Levell',
                'role' => 'Administrateur',
                'phone' => '+221 770000000',
                'avatar_url' => null,
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );
    }
}
