<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('stock_id')->unsigned();
            $table->date('date')->nullable(); // last updated date
            $table->double('low')->nullable(); // last low price
            $table->double('high')->nullable(); // last high price
            $table->double('price')->nullable(); // last price
            $table->double('variation')->nullable(); // last variation in percentage
            $table->timestamps();

            $table->foreign('stock_id')
                    ->references('id')
                    ->on('stocks')
                    ->onDelete('cascade');

            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_infos');
    }
}
