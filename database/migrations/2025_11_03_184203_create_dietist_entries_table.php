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
        Schema::create('dietist_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('category', [
                'groente',
                'fruit',
                'koolhydraten',
                'vlees',
                'noten',
                'zuivel',
                'kaas',
                'vet',
                'vocht'
            ]);
            $table->string('product_name');
            $table->decimal('grams', 8, 2);
            $table->boolean('is_red_meat')->default(false);
            $table->date('datum');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('datum');
            $table->index('category');
            $table->index(['user_id', 'datum']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dietist_entries');
    }
};
