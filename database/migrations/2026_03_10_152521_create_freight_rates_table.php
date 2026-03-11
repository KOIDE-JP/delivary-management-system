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
        Schema::create('freight_rates', function (Blueprint $table) {
            $table->id();

            // FK relationships
            $table->foreignId('destination_id')->constrained('destinations')->restrictOnDelete();
            $table->foreignId('carrier_id')->constrained('carriers')->restrictOnDelete();
            $table->foreignId('truck_type_id')->constrained('truck_types')->restrictOnDelete();

            // Price (tax excluded)
            $table->decimal('price', 15, 2)->comment('Tax excluded price');
            $table->boolean('status')->default(1);

            // Audit columns
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Business constraint: one price per (destination + carrier + truck_type) combination
            $table->unique(['destination_id', 'carrier_id', 'truck_type_id'], 'uq_freight_rate_combination');

            // Indexes
            $table->index('destination_id');
            $table->index('carrier_id');
            $table->index('truck_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freight_rates');
    }
};
