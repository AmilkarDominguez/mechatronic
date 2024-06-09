<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrderBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_batches', function (Blueprint $table) {
            $table->string('uuid')->inique();
            $table->primary(['uuid']);
            $table->integer('quantity')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('service_order_id')->nullable();
            $table->foreign('batch_id')->references('id')->on('batches')->onDedelete('cascade');
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
        Schema::dropIfExists('service_order_batches');
    }
}
