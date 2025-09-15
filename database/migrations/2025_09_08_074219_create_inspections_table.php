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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serial_number_id')->nullable()->constrained('serial_numbers', 'id', 'idx_inspections_serial_number_id')
              ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('sn');
            $table->dateTime('inspection_date');
            $table->dateTime('next_inspection_date');
            $table->string('inspector');
            $table->mediumText('inspection_note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
