<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['title' => 'user_management_access',],
            ['title' => 'user_management_create',],
            ['title' => 'user_management_edit',],
            ['title' => 'user_management_view',],
            ['title' => 'user_management_delete',],
            ['title' => 'permission_access',],
            ['title' => 'permission_create',],
            ['title' => 'permission_edit',],
            ['title' => 'permission_view',],
            [ 'title' => 'permission_delete',],
            [ 'title' => 'role_access',],
            [ 'title' => 'role_create',],
            [ 'title' => 'role_edit',],
            [ 'title' => 'role_view',],
            [ 'title' => 'role_delete',],
            [ 'title' => 'user_access',],
            [ 'title' => 'user_create',],
            [ 'title' => 'user_edit',],
            [ 'title' => 'user_view',],
            [ 'title' => 'user_delete',],
            [ 'title' => 'category_access',],
            [ 'title' => 'category_create',],
            [ 'title' => 'category_edit',],
            [ 'title' => 'category_view',],
            [ 'title' => 'category_delete',],
            [ 'title' => 'tag_access',],
            [ 'title' => 'tag_create',],
            [ 'title' => 'tag_edit',],
            [ 'title' => 'tag_view',],
            [ 'title' => 'tag_delete',],
            [ 'title' => 'product_access',],
            [ 'title' => 'product_create',],
            [ 'title' => 'product_edit',],
            [ 'title' => 'product_view',],
            [ 'title' => 'product_delete',],
            [ 'title' => 'slide_access',],
            [ 'title' => 'slide_create',],
            [ 'title' => 'slide_edit',],
            [ 'title' => 'slide_view',],
            [ 'title' => 'slide_delete',],
        ];

            Permission::insert($permissions);

    }
}
