<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_status_contract')->truncate();
        DB::update("ALTER TABLE master_status_contract AUTO_INCREMENT = 1");

        DB::table('master_status_contract')->insert([
            ['name' => 'Chưa ký'],
            ['name' => 'Đã ký '],
            ['name' => 'Đã xuất hóa đơn'],
            ['name' => 'Đã thanh toán'],

        ]);
    }
}
