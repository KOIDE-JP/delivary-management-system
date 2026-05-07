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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | BASIC INFO
            |--------------------------------------------------------------------------
            */
            $table->string('order_number')->unique();
            $table->string('order_name');
            $table->date('registered_date');

            /*
            |--------------------------------------------------------------------------
            | DELIVERY & SHIPPING
            |--------------------------------------------------------------------------
            */
            $table->date('due_date')->nullable();
            $table->enum('due_confidence', ['confirmed', 'unconfirmed'])->nullable();
            $table->date('inspection_date')->nullable();
            $table->enum('priority', ['no', 'yes'])->default('no');

            $table->date('shipping_date')->nullable();
            $table->enum('shipping_status', [
                'unconfirmed',
                'unarranged',
                'arranged',
                'direct_delivery',
                'courier'
            ])->nullable();

            /*
            |--------------------------------------------------------------------------
            | DOCUMENTS & BILLING
            |--------------------------------------------------------------------------
            */
            $table->enum('dw_status', ['not_shipped', 'shipped', 'no_shipping_required'])->default('not_shipped');
            $table->enum('quotation_status', ['submitted', 'not_submitted', 'not_required'])->default('not_submitted');
            $table->enum('order_status', ['received', 'not_received', 'not_required', 'completed'])->default('not_received');

            // Client Schedule
            $table->date('material_pickup_date')->nullable();
            $table->date('inspection_due_date')->nullable();
            $table->date('parts_pickup_date')->nullable();

            // Billing
            $table->enum('inspection_slip_status', ['received', 'not_received', 'not_required'])->default('not_received');
            $table->enum('invoice_status', ['sent', 'not_sent', 'not_required'])->default('not_sent');
            $table->decimal('order_amount', 12, 2)->nullable();

            /*
            |--------------------------------------------------------------------------
            | FREIGHT INFO
            |--------------------------------------------------------------------------
            */
            $table->string('destination')->nullable(); // prefecture
            $table->string('carrier')->nullable();
            $table->string('truck_type')->nullable();
            $table->decimal('freight_master_price', 12, 2)->nullable();
            $table->decimal('freight_price', 12, 2)->nullable();
            $table->boolean('freight_is_manual')->default(0);
            $table->text('freight_note')->nullable();
            $table->decimal('tax_rate', 5, 2)->default(0.10);
            $table->decimal('freight_tax_amount', 15, 2)->nullable();
            $table->decimal('freight_total_amount', 15, 2)->nullable();

            /*
            |--------------------------------------------------------------------------
            | INTERNAL DATES
            |--------------------------------------------------------------------------
            */
            $table->date('pickup_transfer_date')->nullable();
            $table->date('sales_transfer_date')->nullable();
            $table->date('shipping_transfer_date')->nullable();

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
