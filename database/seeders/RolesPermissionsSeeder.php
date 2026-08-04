<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    public function run()
    {
        $abilities = [
            'view',
            'create',
            'edit',
            'delete',
            'import',
            'export',
        ];

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Schema::disableForeignKeyConstraints();
        // DB::table('users_permissions')->truncate();
        DB::table('users_model_has_roles')->truncate();
        DB::table('users_role_has_permissions')->truncate();
        DB::table('users_model_has_permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        // // User permissions
        // Permission::create(['name' => 'view users']);
        // Permission::create(['name' => 'create users']);
        // Permission::create(['name' => 'edit users']);
        // Permission::create(['name' => 'delete users']);
        // // Roles permissions
        // Permission::create(['name' => 'view roles']);
        // Permission::create(['name' => 'create roles']);
        // Permission::create(['name' => 'edit roles']);
        // Permission::create(['name' => 'delete roles']);
        // // Permissions
        // Permission::create(['name' => 'view permissions']);
        // Permission::create(['name' => 'create permissions']);
        // Permission::create(['name' => 'edit permissions']);
        // Permission::create(['name' => 'delete permissions']);

        $Menu = Menu::All();
        foreach ($Menu as $m) {
            if (!empty($m->code)) {
                if ($m->view == 'Y') {
                    Permission::firstOrCreate(['name' => 'view ' . $m->code]);
                }
                if ($m->create == 'Y') {
                    Permission::firstOrCreate(['name' => 'create ' . $m->code]);
                }
                if ($m->edit == 'Y') {
                    Permission::firstOrCreate(['name' => 'edit ' . $m->code]);
                }
                if ($m->delete == 'Y') {
                    Permission::firstOrCreate(['name' => 'delete ' . $m->code]);
                }
                if ($m->active == 'Y') {
                    Permission::firstOrCreate(['name' => 'active ' . $m->code]);
                }
                if ($m->evaluate == 'Y') {
                    Permission::firstOrCreate(['name' => 'evaluate ' . $m->code]);
                }
                if ($m->approve == 'Y') {
                    Permission::firstOrCreate(['name' => 'approve ' . $m->code]);
                }
                if ($m->upload == 'Y') {
                    Permission::firstOrCreate(['name' => 'upload ' . $m->code]);
                }
                if ($m->export == 'Y') {
                    Permission::firstOrCreate(['name' => 'export ' . $m->code]);
                }
            }
        }

        User::find(1)->assignRole('Developer');
        Role::find(1)->givePermissionTo(Permission::all());

        User::where('email', 'admin@demo.com')->first()->assignRole('Admin');
        User::where('email', 'demo@demo.com')->first()->assignRole('Admin');
        Role::find(2)->givePermissionTo(Permission::where('name', 'not like', '%permissions')->where('name', 'not like', 'create roles')->get());

        // // create roles and assign created permissions
        // $role = Role::firstOrCreate(['name' => 'super-admin']);
        // $role->givePermissionTo(Permission::all());

        // // this can be done as separate statements
        // $role = Role::firstOrCreate(['name' => 'writer']);
        // $role->givePermissionTo('edit articles');

        // // or may be done by chaining
        // $role = Role::create(['name' => 'moderator'])
        //     ->givePermissionTo(['publish articles', 'unpublish articles']);

        // $role = Role::create(['name' => 'super-admin']);
        // $role->givePermissionTo(Permission::all());
    }
}
// php artisan db:seed --class=RolesPermissionsSeeder
