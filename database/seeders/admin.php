<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'neer',
            'email'=>'neer@gmail.com',
            'password'=>Hash::make('neer@123'),
          
        ]);
    }
}
//php artisan make:seeder admin
//php artisan db:seed
