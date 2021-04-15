<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('from_user_id')
                ->references('id')
                ->on('users');
            $table->foreignId('to_user_id')
                ->references('id')
                ->on('users');

            $table->smallInteger('status_id')->unsigned()->nullable();
            $table->foreign('status_id')
                ->references('id')->on('user_transaction_statuses');

            $table->foreignId('schedule_id')->nullable();
            $table->bigInteger('amount');

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
        Schema::dropIfExists('user_transactions');
    }
}
