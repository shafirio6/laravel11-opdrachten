<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'index project']);
        Permission::create(['name' => 'show project']);
        Permission::create(['name' => 'create project']);
        Permission::create(['name' => 'edit project']);
        Permission::create(['name' => 'delete project']);

        Permission::create(['name' => 'index task']);
        Permission::create(['name' => 'show task']);
        Permission::create(['name' => 'create task']);
        Permission::create(['name' => 'edit task']);
        Permission::create(['name' => 'delete task']);

        $student = Role::create(['name' => 'student'])
            ->givePermissionTo(
                'index project', 'show project', 'create project', 'edit project', 'delete project',
                'index task', 'show task', 'create task', 'edit task', 'delete task'
            );

//        $student = Role::create(['name' => 'student'])
//            ->givePermissionTo();

        $teacher = Role::create(['name' => 'teacher'])
            ->givePermissionTo(Permission::all());


        $admin = Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::all());




    }
}
