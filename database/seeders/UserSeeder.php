<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name'=>'Super Admin',
        //     'username'=>'admin',
        //     'email'=>'admin@admin.com',
        //     'password'=>Hash::make('12345678'),
        //     'role'=>'admin'
        // ]);
        $user = User::find(1);

        $user->assignRole('superadmin');
    }
}
