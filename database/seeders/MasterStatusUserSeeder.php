<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_status_user')->truncate();
        DB::update("ALTER TABLE master_status_user AUTO_INCREMENT = 1");

        DB::table('master_status_user')->insert([
            ['name' => 'Bận rộn'],
            ['name' => 'Bận một nửa'],
            ['name' => 'Đang rảnh rỗi'], 
            ['name' => 'Thôi việc'],
        ]);
    }
}
