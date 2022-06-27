<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_status_resource')->truncate();
        DB::update("ALTER TABLE master_status_resource AUTO_INCREMENT = 1");

        DB::table('master_status_resource')->insert([
            ['name' => 'In'],
            ['name' => 'Out'],
        ]);
    }
}
