<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->double('amount', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->integer('model_id')->unsigned()->nullable();
            $table->string('model_type')->nullable();
            $table->string('history')->nullable();
            $table->string('source');
            $table->string('trans_id')->nullable();
            $table->boolean('is_complete')->nullable();
            $table->boolean('is_paid')->nullable();
            $table->string('result_code')->nullable();
            $table->string('card_number')->nullable();
            $table->timestamps();

            $table->index(['model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
