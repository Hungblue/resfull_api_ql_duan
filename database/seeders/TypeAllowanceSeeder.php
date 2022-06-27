<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TypeAllowanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('allowance')->truncate();
        DB::update("ALTER TABLE allowance AUTO_INCREMENT = 1");
        DB::table('allowance')->insert([
            [
                'allowance_name' => 'Phụ cấp ăn trưa'
            ],
            [
            	'allowance_name'=>'Phụ cấp onsite'
            ],
            [
            	'allowance_name'=>'Phụ cấp đi lại'
            ],
            [
            	'allowance_name'=>'Phụ cấp team lead'
            ],
            [
            	'allowance_name'=>'Phụ cấp điện thoại'
            ],
            [
            	'allowance_name'=>'Khác', 
            ]
        ]);
    }
}
