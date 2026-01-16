<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->string('unit_no');

            $table->string('type')->nullable(); // residential / shop / office
            $table->integer('size_sqft')->nullable();

            $table->string('status')->default('active');

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['block', 'unit_no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
