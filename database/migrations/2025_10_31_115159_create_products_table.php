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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('naam');
            $table->decimal('kcal', 8, 2);
            $table->decimal('vet', 8, 2);
            $table->decimal('verzadigd', 8, 2);
            $table->decimal('koolhydraten', 8, 2);
            $table->decimal('suiker', 8, 2);
            $table->decimal('eiwit', 8, 2);
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('naam');
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
