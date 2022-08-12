<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_region', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('region_id');
            $table->double('price_purchase');
            $table->double('price_selling');
            $table->double('price_discount');

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('cascade');

            $table->foreign('region_id')
                ->references('id')
                ->on('region')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
