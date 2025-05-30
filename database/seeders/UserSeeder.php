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
        // Create users => with roles [Super Admin, Admin, Editor, Viewer]

        $superAdmin = User::create([
            'name' => 'Super Admin User',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole('Super Admin');

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('Admin');

        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $editor->assignRole('Editor');
        $viewer = User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $viewer->assignRole('Viewer');
    }
}
