<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Set Havencare Super admin
        DB::table('users')->insert([
            'name'=>'Super Admin',
            'email'=>'sadmin@gmail.com',
            'password' => Hash::make('123456789'),
            'user_type'=>'2',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
