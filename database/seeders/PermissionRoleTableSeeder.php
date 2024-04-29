<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Moawiaab\QTheme\Models\Permission;
use Moawiaab\QTheme\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return
                // substr($permission->title, 0, 5) != 'user_'
                // && substr($permission->title, 0, 5) != 'role_'
                substr($permission->title, 0, 11) != 'permission_'
                && substr($permission->title, 0, 8) != 'account_';
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);
    }
}
