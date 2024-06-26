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
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->decimal('cost', 8, 2)->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('slug')->inique();
            $table->enum('state', ['ACTIVE', 'INACTIVE', 'DELETED'])->default('ACTIVE');
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
