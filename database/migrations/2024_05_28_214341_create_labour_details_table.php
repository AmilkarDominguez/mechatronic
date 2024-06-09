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
        Schema::create('labour_details', function (Blueprint $table) {
            $table->string('uuid')->inique();
            $table->primary(['uuid']);
            $table->decimal('employee_percentage', 8, 2)->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('service_order_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDedelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDedelete('cascade');
            $table->foreign('service_order_id')->references('id')->on('service_orders')->onDedelete('cascade');
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
        Schema::dropIfExists('labour_details');
    }
};
