<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterTypeSkill extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_type_skill')->truncate();
        DB::update("ALTER TABLE master_type_skill AUTO_INCREMENT = 1");
        DB::table('master_type_skill')->insert([
            ['name_type_skill' => 'Kỹ năng mềm'],
            ['name_type_skill' => 'Kỹ năng lập trình'],
        ]);
    }
}
