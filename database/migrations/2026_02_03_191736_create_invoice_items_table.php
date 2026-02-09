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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->constrained();

            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2); // 

            $table->boolean('has_design')->default(false);
            $table->decimal('design_price', 15, 2)->default(0);

            $table->decimal('total_price', 15, 2); // (unit_price * quantity) + design_price

            $table->string('cycle_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
