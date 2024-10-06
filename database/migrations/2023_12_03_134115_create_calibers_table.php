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
        Schema::create('calibers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_medicine_id')->constrained('company_medicine')->cascadeOnDelete();
            $table->integer('caliber')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('quantity');
            $table->bigInteger('total_quantity');
            $table->date('expiration_date');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calibers');
    }
};
