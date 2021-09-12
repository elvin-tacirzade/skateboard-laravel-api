<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = array('6 to 8 years', '9 to 12 years', '13 years to Adult');
        for ($i = 0; $i < 3; $i++) {
            DB::table('type')->insert([
                "name" => $type[$i],
                "created_at"=> date('Y-m-d H:i:s'),
                "updated_at" =>date('Y-m-d H:i:s')
            ]);
        }
    }
}
