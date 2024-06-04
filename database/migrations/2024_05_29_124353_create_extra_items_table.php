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
        Schema::create('extra_items', function (Blueprint $table) {
            $table->string('uuid')->inique();
            $table->primary(['uuid']);
            $table->string('item');
            $table->decimal('cost', 8, 2)->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->onDedelete('cascade');
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
