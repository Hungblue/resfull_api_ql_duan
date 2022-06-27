<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::update("ALTER TABLE users AUTO_INCREMENT = 1");
        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => bcrypt('Miraisoft@54321'),
                'email' => 'admin@miraisoft.com.vn',
                'role_id'=> 1, 
            ],
            
        ]);
    }
}
