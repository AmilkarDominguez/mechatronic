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
        Schema::create('service_order_extra_items', function (Blueprint $table) {
            $table->string('uuid')->inique();
            $table->primary(['uuid']);
            $table->decimal('cost', 8, 2)->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->unsignedBigInteger('extra_item_id')->nullable();
            $table->foreign('extra_item_id')->references('id')->on('extra_items')->onDedelete('cascade');
            $table->unsignedBigInteger('service_order_id')->nullable();
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
        Schema::dropIfExists('extra_items');
    }
};
