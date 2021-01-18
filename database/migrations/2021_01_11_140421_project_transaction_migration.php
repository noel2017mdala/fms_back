<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectTransactionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectTransactions', function (Blueprint $table) {
            $table->bigIncrements('project_transaction_id');
            $table->string('transaction_name');
            $table->integer('projects_id');
            $table->integer('transaction_ammount');
            $table->integer('transaction_type');
            $table->integer('transaction_by');
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
