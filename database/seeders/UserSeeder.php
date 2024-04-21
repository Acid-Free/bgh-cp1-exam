<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('asdf'),
            'remember_token' => 'E32dx325dslkajsdfoij2',
        ]);
    }
}
