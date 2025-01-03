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
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('slug')->inique()->nullable();
            $table->enum('type', ['INGRESO', 'EGRESO'])->nullable();
            $table->enum('state', ['ACTIVE', 'INACTIVE', 'DELETED'])->default('ACTIVE');
            $table->boolean('allow_deletion')->default(true);
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
        Schema::dropIfExists('transaction_types');
    }
};
