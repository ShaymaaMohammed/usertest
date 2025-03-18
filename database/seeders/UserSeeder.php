<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure role exists
        Role::firstOrCreate(['name' => 'Admin']);

        // Find the user
        $user = User::where('email', 'sha@gmail.com')->first();

        if ($user) {
            $user->assignRole('Admin');
        }


        Role::firstOrCreate(['name' => 'user']);

        // Find the user
        $user = User::where('email', 'shay4@gmail.com')->first();

        if ($user) {
            $user->assignRole('user');
        }

    
    }
}
