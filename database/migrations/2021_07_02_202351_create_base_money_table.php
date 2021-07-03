<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_money', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('action_type');
            $table->integer('id_denomination_money')->unsigned();
            $table->integer('id_payments')->unsigned()->nullable();
            $table->boolean('status')->default('1');
            $table->foreign('id_denomination_money')->references('id')->on('denomination_money')->onDelete('cascade');
            $table->foreign('id_payments')->references('id')->on('payments')->onDelete('cascade');
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
        Schema::dropIfExists('base_money');
    }
}
