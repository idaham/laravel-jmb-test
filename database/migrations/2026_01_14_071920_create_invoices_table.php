<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unit_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('invoice_no')->unique();
            $table->string('billing_period'); // e.g. 2025-01

            $table->date('issue_date');
            $table->date('due_date');

            $table->decimal('total_amount', 10, 2)->default(0);

            $table->enum('status', [
                'draft',
                'issued',
                'partial',
                'paid',
                'overdue',
            ])->default('draft');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Prevent duplicate invoices per unit per period
            $table->unique(['unit_id', 'billing_period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

