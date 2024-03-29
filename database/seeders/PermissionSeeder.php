<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name'=>'user',
            'display_name'=>'Kelola Data User'
        ]);

        Permission::create([
            'name'=>'role',
            'display_name'=>'Kelola Data Role'
        ]);
    }
}
