<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        \Spatie\Permission\Models\Role::create(['name' => 'Super Admin']);
        \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
        \Spatie\Permission\Models\Role::create(['name' => 'Editor']);
        \Spatie\Permission\Models\Role::create(['name' => 'Viewer']);

        // Assign permissions to roles
        $adminRole = \Spatie\Permission\Models\Role::findByName('Admin');
        $editorRole = \Spatie\Permission\Models\Role::findByName('Editor');
        $viewerRole = \Spatie\Permission\Models\Role::findByName('Viewer');

        $permissions = \Spatie\Permission\Models\Permission::all();

        foreach ($permissions as $permission) {
            // Admin: super user, gets all permissions
            $adminRole->givePermissionTo($permission);

            // Editor: can view all routes, and can do anything on articles
            if (
                str_starts_with($permission->name, 'view') ||
                str_contains($permission->name, 'articles')
            ) {
                $editorRole->givePermissionTo($permission);
            }

            // Viewer: only view permissions
            if (str_starts_with($permission->name, 'view')) {
                $viewerRole->givePermissionTo($permission);
            }
        }
    }
}
