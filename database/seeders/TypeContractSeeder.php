<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB; 

class TypeContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_type')->truncate();
        DB::update("ALTER TABLE contract_type AUTO_INCREMENT = 1");
        DB::table('contract_type')->insert([
            [
                'contract_name' => 'Thực tập sinh'
            ],
            [
            	'contract_name'=>'Hợp đồng thử việc'
            ],
            [
            	'contract_name'=>'Hợp đồng học việc'
            ],
            [
            	'contract_name'=>'Hợp đồng 1 năm'
            ],
            [
            	'contract_name'=>'Hợp đồng 3 năm'
            ],
            [
            	'contract_name'=>'Không xác định thời hạn'
            ],
        ]);
    }
}
