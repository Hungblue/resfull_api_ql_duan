<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MasterTypeSeeder::class,
            MasterSkillSeeder::class,
            MasterStatusContractSeeder::class,
            MasterStatusDeadlineSeeder::class,
            MasterStatusResourceSeeder::class,
            MasterStatusUserSeeder::class,
            RoleSeeder::class,
            PositionSeeder::class,
            TypeAllowanceSeeder::class,
            TypeContractSeeder::class,
            MasterTypeSkill::class,
            MasterTypeAssess::class,
            MasterLevelSkill::class,
            UserSeeder::class,
        ]);
    }
}
