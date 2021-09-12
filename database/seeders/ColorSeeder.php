<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color = array(
            "blue" => "#0000FF",
            "red" => "#FF0000",
            "green" => "#00FF00",
        );

        for ($i = 0; $i < 3; $i++) {
            $name = array_keys($color)[$i];
            DB::table('color')->insert([
                "name" => $name,
                "hex_code" => $color[$name],
                "created_at"=> date('Y-m-d H:i:s'),
                "updated_at" =>date('Y-m-d H:i:s')
            ]);
        }
    }
}
