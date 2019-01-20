<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockcards', function (Blueprint $table) {
            $table->increments('id');
//            $table->foreign('product_id')->references('id')->on('products');
//            $table->foreign('user_id')->references('id')->on('users');
            $table->string('description');
            $table->integer('qtyreceived')->default(0);
            $table->integer('qtyout')->default(0);
            $table->integer('currentbalance');
            $table->string('invoiceno');
            $table->string('bacthno');
            $table->dateTime('mfd_date')->nullable();
            $table->dateTime('exp_date')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('stockcards');
    }
}
