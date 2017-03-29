<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\User;
use App\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       

        //Create permissions
        $role_list = new Permission();
        $role_list ->name = 'role-list';
        $role_list ->display_name = 'Display Role Listing';
        $role_list ->save();

        $role_create = new Permission();
        $role_create ->name = 'role-create';
        $role_create ->display_name = 'Create Role';
        $role_create ->save();

        $role_edit = new Permission();
        $role_edit ->name = 'role-edit';
        $role_edit ->display_name = 'Edit Role';
        $role_edit ->save();

        $role_delete = new Permission();
        $role_delete ->name = 'role-delete';
        $role_delete ->display_name = 'Delete Role';
        $role_delete ->save();

        //Create roles
        $admin = new Role();
        $admin->name = 'admin';
        $admin->save();
        $admin->attachPermission($role_list);
        $admin->attachPermission($role_create);
        $admin->attachPermission($role_edit);
        $admin->attachPermission($role_delete);        

        //Create user
        $user = new User();
        $user->name = 'admin';
        $user->password = bcrypt('password');
        $user->save();
        $user->attachRole($admin);

    }
}