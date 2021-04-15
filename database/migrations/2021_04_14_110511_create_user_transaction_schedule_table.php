<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTransactionScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_transaction_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('from_user_id')
                ->references('id')
                ->on('users');
            $table->foreignId('to_user_id')
                ->references('id')
                ->on('users');

            $table->smallInteger('status_id')->unsigned()->nullable();
            $table->foreign('status_id')
                ->references('id')->on('user_transaction_schedule_statuses');

            $table->uuid('transaction_id')->nullable();
            $table->foreign('transaction_id')
                ->references('id')->on('user_transactions');
            $table->bigInteger('amount');

            $table->dateTime('schedule_at');
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
        Schema::dropIfExists('user_transaction_schedules');
    }
}
