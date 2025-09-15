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
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('brand_code', 16);
            $table->string('type_code', 16);
            $table->string('product_code', 32);
            $table->string('product_name');
            $table->string('buyer_name');
            $table->string('sn')->unique('idx_serial_numbers_sn');
            $table->dateTime('production_date');
            $table->dateTime('hydrotest_date');
            $table->dateTime('next_hydrotest_date');
            $table->dateTime('expired_date');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id', 'idx_serial_numbers_created_by')
              ->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_numbers');
    }
};
