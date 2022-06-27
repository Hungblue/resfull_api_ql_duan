<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->truncate();
        DB::update("ALTER TABLE role AUTO_INCREMENT = 1");
        DB::table('role')->insert([
            [
                'name' => 'Quản trị hệ thống'
            ],
            [
                'name' => 'Ban lãnh đạo công ty'
            ],
            [
            	'name'=>'Phòng tổng hợp'
            ],
            [
            	'name'=>'Nhân viên'
            ]
        ]);
    }
}
