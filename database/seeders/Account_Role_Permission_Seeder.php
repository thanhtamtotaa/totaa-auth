<?php

namespace ToTaa\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Account_Role_Permission_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Permission::where("name", "view-account")->count() == 0) {
            $permission[] = Permission::create(['name' => 'view-account', "description" => "Xem Account", "group" => "Account", "order" => 1, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "view-account")->first();
        }

        if (Permission::where("name", "add-account")->count() == 0) {
            $permission[] = Permission::create(['name' => 'add-account', "description" => "Thêm Account", "group" => "Account", "order" => 2, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "add-account")->first();
        }

        if (Permission::where("name", "edit-account")->count() == 0) {
            $permission[] = Permission::create(['name' => 'edit-account', "description" => "Sửa Account", "group" => "Account", "order" => 3, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "edit-account")->first();
        }

        if (Permission::where("name", "delete-account")->count() == 0) {
            $permission[] = Permission::create(['name' => 'delete-account', "description" => "Xóa Account", "group" => "Account", "order" => 4, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "delete-account")->first();
        }

        if (Role::where("name", "super-admin")->count() == 0) {
            $super_admin =  Role::create(['name' => 'super-admin', "description" => "Super Admin", "group" => "Admin", "order" => 1, "lock" => true,]);
        } else {
            $super_admin= Role::where("name", "super-admin")->first();
        }

        if (Role::where("name", "admin")->count() == 0) {
            $admin = Role::create(['name' => 'admin', "description" => "Admin", "group" => "Admin", "order" => 2, "lock" => true,]);
        } else {
            $admin = Role::where("name", "admin")->first();
        }

        if (Role::where("name", "admin-account")->count() == 0) {
            $admin_account = Role::create(['name' => 'admin-account', "description" => "Admin Quản lý Tài khoản", "group" => "Admin", "order" => 2, "lock" => true,]);
        } else {
            $admin_account = Role::where("name", "admin-account")->first();
        }

        $super_admin->givePermissionTo($permission);
        $admin->givePermissionTo($permission);
        $admin_account->givePermissionTo($permission);
    }
}
