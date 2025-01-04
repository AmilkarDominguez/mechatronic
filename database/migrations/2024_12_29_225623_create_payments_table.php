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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('slug')->inique();
            $table->enum('state', ['ACTIVE', 'INACTIVE', 'DELETED'])->default('ACTIVE');
            $table->unsignedBigInteger('service_order_id');
            $table->foreign('service_order_id')->references('id')->on('service_orders')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
};
