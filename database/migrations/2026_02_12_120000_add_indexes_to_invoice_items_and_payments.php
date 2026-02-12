<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            // composite index used frequently in queries
            $table->index(['doctor_id', 'is_archived'], 'idx_invoice_items_doctor_archived');
            // used to lookup archived cycles quickly
            $table->index('cycle_code', 'idx_invoice_items_cycle_code');
            // index on created_at can help range queries
            $table->index('created_at', 'idx_invoice_items_created_at');
        });

        Schema::table('payments', function (Blueprint $table) {
            // queries filter by doctor and created_at ranges
            $table->index(['doctor_id', 'created_at'], 'idx_payments_doctor_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropIndex('idx_invoice_items_doctor_archived');
            $table->dropIndex('idx_invoice_items_cycle_code');
            $table->dropIndex('idx_invoice_items_created_at');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('idx_payments_doctor_created_at');
        });
    }
};
