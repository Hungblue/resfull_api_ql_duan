<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusDeadlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_status_deadline')->truncate();
        DB::update("ALTER TABLE master_status_deadline AUTO_INCREMENT = 1");

        DB::table('master_status_deadline')->insert([
            ['name' => 'Đang mở'],
            ['name' => 'Đang thực hiện'],
            ['name' => 'Đóng'],
            ['name' => 'Đã bàn giao'],
            ['name' => 'Đã hủy'],
            ['name' => 'Đã nghiệm thu'],

        ]);
    }
}
