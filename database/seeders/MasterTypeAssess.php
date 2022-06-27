<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterTypeAssess extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_type_status_assess')->truncate();
        DB::update("ALTER TABLE master_type_status_assess AUTO_INCREMENT = 1");
        DB::table('master_type_status_assess')->insert([
            [
                'name_type_assess' => 'Đang mở'
            ],
            [
            	'name_type_assess'=>'Đang đánh giá'
            ],
            [
            	'name_type_assess'=>'Đang chờ leader'
            ],
            [
            	'name_type_assess'=>'Đã đánh giá'
            ],
            [
            	'name_type_assess'=>'Đã hoàn thành'
            ],
        ]);
    }
}
