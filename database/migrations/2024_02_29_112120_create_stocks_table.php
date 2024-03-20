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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('net_weight')->nullable();
            $table->integer('gross_weight')->nullable();
            $table->integer('moisture_discount')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('summary_id')->nullable();
            $table->integer('price')->nullable()->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('total')->nullable();
            $table->string('action')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
