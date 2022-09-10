<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // creating a admin user role
        $adminRole = Role::create(['name' => 'admin']);

        // creating and assigning a admin user permissions for:
        // staff
        // machine
        // machine refuelling

        $addMachineRefuelling = Permission::create(['name' => 'add machine refuelling']);
        $viewMachineRefuelling = Permission::create(['name' => 'view machine refuelling']);
        $updateMachineRefuelling = Permission::create(['name' => 'update machine refuelling']);
        $deleteMachineRefuelling = Permission::create(['name' => 'delete machine refuelling']);

        $adminRole->syncPermissions([
            Permission::create(['name' => 'add staff']),
            Permission::create(['name' => 'view staff']),
            Permission::create(['name' => 'update staff']),
            Permission::create(['name' => 'delete staff']),
            Permission::create(['name' => 'add machine']),
            Permission::create(['name' => 'view machine']),
            Permission::create(['name' => 'update machine']),
            Permission::create(['name' => 'delete machine']),
            $addMachineRefuelling,
            $viewMachineRefuelling,
            $updateMachineRefuelling,
            $deleteMachineRefuelling
        ]);

        // creating a staff user role
        $staffRole = Role::create(['name' => 'staff']);

        $canLogin = Permission::create(['name' => 'can login']);

        // creating and assigning a staff user permissions for:
        // login
        // machine refuelling
        $staffRole->syncPermissions([
            $canLogin,
            $addMachineRefuelling,
            $viewMachineRefuelling,
            $updateMachineRefuelling,
        ]);
    }
}
