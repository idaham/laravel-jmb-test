<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            // Drop old unique index
            $table->dropUnique('units_block_unit_no_unique');

            // Add correct unique index
            $table->unique(['block', 'floor', 'unit_no']);
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropUnique(['block', 'floor', 'unit_no']);
            $table->unique(['block', 'unit_no']);
        });
    }
};
