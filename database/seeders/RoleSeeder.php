<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
          
            [
                'role_name' => "admin", 
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'role_name' => "user", 
                'created_at' => new \DateTime,
                'updated_at' => null,
            ], 
        ];
    
        \DB::table('roles')->insert($roles);
    }
}
