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
        Schema::create('company_medicine', function (Blueprint $table) {
            $table->id();
           $table->foreignId('company_id')->constrained()->cascadeOnDelete();
           $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
           $table->string('commercial_name');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_medicine');
    }
};
