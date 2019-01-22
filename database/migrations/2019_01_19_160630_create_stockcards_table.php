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
            $table->integer('product_id');
            $table->integer('user_id');
            $table->string('description')->nullable();
            $table->integer('qtyreceived')->default(0);
            $table->integer('qtyout')->default(0);
            $table->integer('currentbalance');
            $table->string('invoiceno')->nullable();
            $table->string('bacthno')->nullable();
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
