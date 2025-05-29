<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions for articles
        \Spatie\Permission\Models\Permission::create(['name' => 'view articles']);
        \Spatie\Permission\Models\Permission::create(['name' => 'create articles']);
        \Spatie\Permission\Models\Permission::create(['name' => 'edit articles']);
        \Spatie\Permission\Models\Permission::create(['name' => 'delete articles']);

        // Create permissions for roles
        \Spatie\Permission\Models\Permission::create(['name' => 'view roles']);
        \Spatie\Permission\Models\Permission::create(['name' => 'create roles']);
        \Spatie\Permission\Models\Permission::create(['name' => 'edit roles']);
        \Spatie\Permission\Models\Permission::create(['name' => 'delete roles']);

        // Create permissions for permissions
        \Spatie\Permission\Models\Permission::create(['name' => 'view permissions']);
        \Spatie\Permission\Models\Permission::create(['name' => 'create permissions']);
        \Spatie\Permission\Models\Permission::create(['name' => 'edit permissions']);
        \Spatie\Permission\Models\Permission::create(['name' => 'delete permissions']);

        // Create permissions for users
        \Spatie\Permission\Models\Permission::create(['name' => 'view users']);
        \Spatie\Permission\Models\Permission::create(['name' => 'create users']);
        \Spatie\Permission\Models\Permission::create(['name' => 'edit users']);
        \Spatie\Permission\Models\Permission::create(['name' => 'delete users']);
    }
}
