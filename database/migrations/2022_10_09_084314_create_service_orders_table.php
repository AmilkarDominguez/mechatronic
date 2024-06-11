<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->decimal('total', 8, 2)->nullable();
            //haber monto pagado
            $table->decimal('have', 8, 2)->nullable()->default(0);
            //debe monto que se debe
            $table->decimal('must', 8, 2)->nullable();
            $table->string('slug')->inique();
            $table->enum('state', ['DRAFT','PENDING', 'COMPLETED', 'DELETED'])->default('PENDING')->nullable();
            $table->enum('payment_type', ['CONTADO', 'CREDITO'])->default('CONTADO')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDedelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDedelete('cascade');
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
        Schema::dropIfExists('service_orders');
    }
}
