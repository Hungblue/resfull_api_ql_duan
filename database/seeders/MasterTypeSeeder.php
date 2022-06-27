<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_types')->truncate();
        DB::update("ALTER TABLE master_types AUTO_INCREMENT = 1");

        DB::table('master_types')->insert([
            ['name' => 'Fixed prices'],
            ['name' => 'Fixed unit prices'],
            ['name' => 'Time material']
        ]);
    }
}
