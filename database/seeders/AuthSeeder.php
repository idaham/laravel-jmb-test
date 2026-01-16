<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AuthSeeder extends Seeder
{
    public function run(): void
    {
        // Clear permission cache
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */
        $permissions = [
            'access system',
            'manage units',
            'manage residents',
            'manage payments',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $clerkRole = Role::firstOrCreate(['name' => 'clerk']);
        $treasurerRole = Role::firstOrCreate(['name' => 'treasurer']);
        $residentRole = Role::firstOrCreate(['name' => 'resident']);

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions to Roles
        |--------------------------------------------------------------------------
        */
        $adminRole->syncPermissions(Permission::all());

        $clerkRole->syncPermissions([
            'access system',
        ]);

        $treasurerRole->syncPermissions([
            'access system',
            'manage payments',
            'view reports',
        ]);

        // Resident intentionally has no system permissions

        /*
        |--------------------------------------------------------------------------
        | Default Admin User
        |--------------------------------------------------------------------------
        */
        $admin = User::firstOrCreate(
            ['email' => 'admin@jmb.test'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
            ]
        );

        if (! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}
