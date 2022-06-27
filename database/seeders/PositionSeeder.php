<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('position')->truncate();
        DB::update("ALTER TABLE position AUTO_INCREMENT = 1");
        DB::table('position')->insert([
            [
                'position_name' => 'Lãnh đạo'
            ],
            [
                'position_name' => 'Quản lý dự án'
            ],
            [
                'position_name' => 'Lập trình viên'
            ],
            [
                'position_name' => 'Kỹ sư cầu nối (BrSE)'
            ],
            [
            	'position_name'=>'Tester'
            ],
            [
            	'position_name'=>'BA'
            ],
            [
            	'position_name'=>'Nhân viên tuyển dụng'
            ],
            [
            	'position_name'=>'Nhân viên văn phòng'
            ],
            [
            	'position_name'=>'Kế toán'
            ],
        ]);
    }
}
