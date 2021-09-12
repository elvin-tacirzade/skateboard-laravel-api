<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('color_id');
            $table->integer('amount');
            $table->float('total_price');
            $table->string('print_photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address');
            $table->dateTime('created_at');
            $table->dateTime('preparation_date')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
