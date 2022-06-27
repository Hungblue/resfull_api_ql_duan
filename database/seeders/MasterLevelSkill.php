<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterLevelSkill extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_level_skill')->truncate();
        DB::update("ALTER TABLE master_level_skill AUTO_INCREMENT = 1");
        DB::table('master_level_skill')->insert([
            ['name_level' => 'Mới bắt đầu'],
            ['name_level' => 'Cơ bản'],
            ['name_level' => 'Thành thục'],
            ['name_level' => 'Chuyên sâu'],
            ['name_level' => 'Chuyên gia'],
        ]);
    }
}
