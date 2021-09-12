<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Skateboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skateboard', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('type_id');
            $table->json('color_id')->comment('Bir Skateboard üçün bir neçə rəng ola bilər');
            $table->float('price');
            $table->integer('print_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skateboard');
    }
}
