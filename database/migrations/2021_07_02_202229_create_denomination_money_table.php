<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenominationMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denomination_money', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('value');            
            $table->integer('id_type')->unsigned();
            $table->boolean('status')->default('1');
            $table->foreign('id_type')->references('id')->on('type_money')->onDelete('cascade');
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
        Schema::dropIfExists('denomination_money');
    }
}
