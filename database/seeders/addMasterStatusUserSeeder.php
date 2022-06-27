<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class addMasterStatusUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_status_user')->insert([
            ['name' => 'resign']
        ]);
    }
}
