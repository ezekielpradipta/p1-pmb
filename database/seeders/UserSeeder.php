<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => "admin",
                'email' => 'admin@email.com',
                'password' => bcrypt('qwerty123'), 
                'is_valid'=>'1', 
                'is_mahasiswa'=>'1', 
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'name' => "user",
                'email' => 'user@email.com',
                'password' => bcrypt('qwerty123'), 
                'is_valid'=>'1',
                'is_mahasiswa'=>'1', 
                'created_at' => new \DateTime,
                'updated_at' => null,
            ], 
          
        ];
        \DB::table('users')->insert($user);
    }
}
