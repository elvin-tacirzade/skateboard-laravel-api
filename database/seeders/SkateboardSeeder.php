<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkateboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skateboards = array(
            'Element', 'Plan B', 'Girl', 'Zero', 'Creature',
            'Blind', 'Santa Cruz', 'Almost', 'Chocolate', 'Flip',
            'Krypton', 'Wheel matter', 'Cameroon’s', 'Lion power', 'Apollo',
            'Gals', 'Honey little', 'Jagger', 'Zero panic', 'Mystery'
        );

        for ($i = 0; $i < count($skateboards); $i++) {
            $price = array();
            for ($j = 0; $j < rand(1, 3); $j++) {
                $rand = rand(1, 3);
                if(!in_array($rand, $price)){
                    array_push($price, $rand);
                }
            }
            DB::table('skateboard')->insert([
                "name" => $skateboards[$i],
                "type_id" => rand(1, 3),
                "color_id" => json_encode($price, true),
                "price" => rand(1 * 100, 2000 * 100) / 100,
                "print_price" => rand(1, 50),
                "created_at"=> date('Y-m-d H:i:s'),
                "updated_at" =>date('Y-m-d H:i:s')
            ]);
        }
    }
}
