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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('brands', 'id', 'idx_products_brand_id')
              ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('type_id')->nullable()->constrained('types', 'id', 'idx_products_type_id')
              ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('capacity_id')->nullable()->constrained('capacities', 'id', 'idx_products_capacity_id')
              ->nullOnDelete()->cascadeOnUpdate();
            $table->string('code', 32)->unique('idx_products_code');
            $table->string('name');
            $table->double('price')->unsigned()->nullable();
            $table->text('image')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
