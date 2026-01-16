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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unit_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('ic_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->enum('type', ['owner', 'tenant'])->default('owner');
            $table->string('status')->default('active');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
