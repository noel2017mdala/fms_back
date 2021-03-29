<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User_Amount_transactions', function(Blueprint $table){
            $table->bigIncrements('user_Amount_id');
            $table->integer('user_id');
            $table->integer('prev_Amount');
            $table->integer('transaction_id');
            $table->string('date_value');
            $table->datetime('transaction_date');
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
}
