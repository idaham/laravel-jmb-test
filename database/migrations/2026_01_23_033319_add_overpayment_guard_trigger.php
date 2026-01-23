<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER prevent_overpayment_before_insert
            BEFORE INSERT ON payments
            FOR EACH ROW
            BEGIN
                DECLARE total_paid DECIMAL(10,2);
                DECLARE invoice_total DECIMAL(10,2);

                SELECT total_amount
                INTO invoice_total
                FROM invoices
                WHERE id = NEW.invoice_id
                LIMIT 1;

                SELECT COALESCE(SUM(amount), 0)
                INTO total_paid
                FROM payments
                WHERE invoice_id = NEW.invoice_id;

                IF (total_paid + NEW.amount) > invoice_total THEN
                    SIGNAL SQLSTATE \'45000\'
                    SET MESSAGE_TEXT = \'Overpayment detected: payment exceeds invoice total\';
                END IF;
            END;
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_overpayment_before_insert');
    }
};
