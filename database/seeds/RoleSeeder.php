<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleSeeder extends Seeder
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

        // this can be done as separate statements
        $member = Role::create(['name' => 'member', 'title' => 'کاربر معمولی']);
        $admin = Role::create(['name' => 'admin', 'title' => 'مدیر']);
        $superadmin = Role::create(['name' => 'superadmin', 'title' => 'مدیرکل']);

        $superadmin->givePermissionTo(Permission::all());
    }
}
