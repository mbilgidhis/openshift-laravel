<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UserRolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // app()['cache']->forget('spatie.permission.cache');
    	app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Department
        Permission::create(['name' => 'create_department']);
        Permission::create(['name' => 'edit_department']);
        Permission::create(['name' => 'delete_department']);
        Permission::create(['name' => 'view_department']);

        // Project
        Permission::create(['name' => 'create_project']);
        Permission::create(['name' => 'edit_project']);
        Permission::create(['name' => 'delete_project']);
        Permission::create(['name' => 'view_project']);
        
        // Plan
        Permission::create(['name' => 'create_plan']);
        Permission::create(['name' => 'edit_plan']);
        Permission::create(['name' => 'delete_plan']);
        Permission::create(['name' => 'view_plan']);

        // Dashboard
        Permission::create(['name' => 'view_dashboard_all']);
        Permission::create(['name' => 'view_dashboard_staff']);

        // Actual
        Permission::create(['name' => 'create_actual']);
        Permission::create(['name' => 'edit_actual']);
        Permission::create(['name' => 'delete_actual']);
        Permission::create(['name' => 'view_actual']);

        // Claim Overtime
        Permission::create(['name' => 'create_claim_overtime']);
        Permission::create(['name' => 'edit_claim_overtime']);
        Permission::create(['name' => 'delete_claim_overtime']);
        Permission::create(['name' => 'view_claim_overtime']);

        // Master data
        Permission::create(['name' => 'create_master_data']);
        Permission::create(['name' => 'view_master_data']);
        Permission::create(['name' => 'edit_master_data']);
        Permission::create(['name' => 'delete_master_data']);
        Permission::create(['name' => 'user_management']);
        Permission::create(['name' => 'manage_report']);

        $role = Role::create(['name' => 'super admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([ 'create_department', 'edit_department', 'delete_department', 'view_department','create_project', 'edit_project', 'delete_project', 'view_project','create_plan', 'edit_plan', 'delete_plan', 'view_plan', 'view_dashboard_all', 'view_actual', 'create_master_data', 'view_master_data', 'edit_master_data', 'edit_master_data', 'delete_master_data', 'user_management', 'manage_report', 'delete_claim_overtime', 'view_claim_overtime']);

        $role = Role::create(['name' => 'staff']);
        $role->givePermissionTo([ 'view_department','view_project', 'create_plan', 'edit_plan', 'delete_plan', 'view_plan', 'view_dashboard_staff', 'create_actual', 'edit_actual', 'delete_actual', 'view_actual', 'view_master_data', 'create_claim_overtime', 'edit_claim_overtime', 'delete_claim_overtime', 'view_claim_overtime']);

        $role = Role::create(['name' => 'manager']);
        $role->givePermissionTo([ 'view_department','create_project', 'edit_project', 'delete_project', 'view_project', 'view_dashboard_all', 'manage_report', 'view_claim_overtime']);

        $user = User::find(1);
        $user->assignRole('super admin');

        $user = User::find(2);
        $user->assignRole('admin');

        $user = User::find(3);
        $user->assignRole('staff');

        $user = User::find(4);
        $user->assignRole('manager');

        $user = User::find(6);
        $user->assignRole('admin');

        // $user = User::find(2);
        // $user->assignRole('moderator');
    }
}
