<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('user_id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->double('quantity')->default(0);
            $table->date('date_buy');
            $table->date('date_sell')->nullable();
            $table->double('price_buy');
            $table->double('price_sell')->nullable();
            $table->double('exchange_fee_buy')->nullable();
            $table->double('exchange_fee_sell')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('user_stocks');
    }
}
