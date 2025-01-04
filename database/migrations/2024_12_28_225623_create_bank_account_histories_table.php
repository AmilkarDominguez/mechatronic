<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_account_histories', function (Blueprint $table) {
            $table->string('uuid')->unique();
            $table->primary('uuid');
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('transaction_type_id')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->decimal('balance', 8, 2)->nullable();
            $table->string('transaction_reference')->nullable();
            $table->timestamps();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_account_histories');
    }
};
