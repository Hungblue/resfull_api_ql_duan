<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_skills')->truncate();
        DB::update("ALTER TABLE master_skills AUTO_INCREMENT = 1");

        DB::table('master_skills')->insert([
            ['name' => 'PHP'],
            ['name' => 'Java'],
            ['name' => 'C#'],
            ['name' => 'Python'],
            ['name' => 'Angular'],
            ['name' => 'AngularJS'],
            ['name' => 'VueJS'],
            ['name' => 'React Native'],
            ['name' => 'ReactJS'],
            ['name' => 'HTML5/JS'],
            ['name' => 'Android'],
            ['name' => 'iOS'],
            ['name' => 'SQL'],
            ['name' => 'BA'],
            ['name' => 'PM'],
            ['name' => 'Tester'],
            ['name' => 'HR'],
            ['name' => 'Kế Toán'],
        ]);
    }
}
