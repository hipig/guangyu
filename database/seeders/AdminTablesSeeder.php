<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        \Encore\Admin\Auth\Database\Menu::truncate();
        \Encore\Admin\Auth\Database\Menu::insert(
            [
                [
                    "parent_id" => 0,
                    "order" => 1,
                    "title" => "仪表盘",
                    "icon" => "fa-dashboard",
                    "uri" => "/",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "系统管理",
                    "icon" => "fa-cogs",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 4,
                    "title" => "管理员",
                    "icon" => "fa-user",
                    "uri" => "auth/users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 5,
                    "title" => "角色",
                    "icon" => "fa-users",
                    "uri" => "auth/roles",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 6,
                    "title" => "权限",
                    "icon" => "fa-ban",
                    "uri" => "auth/permissions",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 7,
                    "title" => "菜单列表",
                    "icon" => "fa-bars",
                    "uri" => "auth/menu",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 3,
                    "title" => "网站设置",
                    "icon" => "fa-cog",
                    "uri" => "/settings",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 9,
                    "title" => "商品管理",
                    "icon" => "fa-product-hunt",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 9,
                    "order" => 12,
                    "title" => "商品属性",
                    "icon" => "fa-cube",
                    "uri" => "goods-attributes",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 9,
                    "order" => 10,
                    "title" => "添加商品",
                    "icon" => "fa-plus",
                    "uri" => "goods/create",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 9,
                    "order" => 11,
                    "title" => "商品列表",
                    "icon" => "fa-circle-o",
                    "uri" => "goods",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 13,
                    "title" => "选号商城",
                    "icon" => "fa-shopping-cart",
                    "uri" => "store",
                    "permission" => NULL
                ]
            ]
        );

        \Encore\Admin\Auth\Database\Permission::truncate();
        \Encore\Admin\Auth\Database\Permission::insert(
            [
                [
                    "name" => "所有权限",
                    "slug" => "*",
                    "http_method" => "",
                    "http_path" => "*"
                ],
                [
                    "name" => "仪表盘",
                    "slug" => "dashboard",
                    "http_method" => "GET",
                    "http_path" => "/"
                ],
                [
                    "name" => "登录",
                    "slug" => "auth.login",
                    "http_method" => "",
                    "http_path" => "/auth/login\r\n/auth/logout"
                ],
                [
                    "name" => "个人设置",
                    "slug" => "auth.setting",
                    "http_method" => "GET,PUT",
                    "http_path" => "/auth/setting"
                ],
                [
                    "name" => "权限管理",
                    "slug" => "auth.management",
                    "http_method" => "",
                    "http_path" => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs"
                ],
                [
                    "name" => "商品属性列表",
                    "slug" => "goods.attributes",
                    "http_method" => "GET",
                    "http_path" => "/goods-attributes"
                ],
                [
                    "name" => "商品属性新增",
                    "slug" => "goods.attributes.create",
                    "http_method" => "GET",
                    "http_path" => "/goods-attributes/create"
                ],
                [
                    "name" => "商品属性添加",
                    "slug" => "goods.attributes.store",
                    "http_method" => "POST",
                    "http_path" => "/goods-attributes"
                ],
                [
                    "name" => "商品属性编辑",
                    "slug" => "goods.attributes.edit",
                    "http_method" => "GET",
                    "http_path" => "/goods-attributes/*/edit"
                ],
                [
                    "name" => "商品属性更新",
                    "slug" => "goods.attributes.update",
                    "http_method" => "PUT",
                    "http_path" => "/goods-attributes/*"
                ],
                [
                    "name" => "商品属性删除",
                    "slug" => "goods.attributes.destroy",
                    "http_method" => "DELETE",
                    "http_path" => "/goods-attributes/*"
                ],
                [
                    "name" => "商品列表",
                    "slug" => "goods",
                    "http_method" => "GET",
                    "http_path" => "/goods"
                ],
                [
                    "name" => "商品新增",
                    "slug" => "goods.create",
                    "http_method" => "GET",
                    "http_path" => "/goods/create"
                ],
                [
                    "name" => "商品添加",
                    "slug" => "goods.store",
                    "http_method" => "POST",
                    "http_path" => "/goods"
                ],
                [
                    "name" => "商品编辑",
                    "slug" => "goods.edit",
                    "http_method" => "GET",
                    "http_path" => "/goods/*/edit"
                ],
                [
                    "name" => "商品更新",
                    "slug" => "goods.update",
                    "http_method" => "PUT",
                    "http_path" => "/goods/*"
                ],
                [
                    "name" => "商品删除",
                    "slug" => "goods.destroy",
                    "http_method" => "DELETE",
                    "http_path" => "/goods/*"
                ]
            ]
        );

        \Encore\Admin\Auth\Database\Role::truncate();
        \Encore\Admin\Auth\Database\Role::insert(
            [
                [
                    "name" => "超级管理员",
                    "slug" => "administrator"
                ]
            ]
        );

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [
                [
                    "role_id" => 1,
                    "menu_id" => 2
                ]
            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    "role_id" => 1,
                    "permission_id" => 1
                ]
            ]
        );

        // finish
    }
}
