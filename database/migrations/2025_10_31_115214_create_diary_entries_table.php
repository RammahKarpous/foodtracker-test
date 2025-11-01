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
        Schema::create('diary_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('product_naam');
            $table->enum('moment', ['Ontbijt', 'Lunch', 'Tussendoor', 'Diner', 'Voor training', 'Na training']);
            $table->decimal('gram', 8, 2);
            $table->decimal('kcal', 8, 2);
            $table->decimal('vet', 8, 2);
            $table->decimal('verzadigd', 8, 2);
            $table->decimal('koolhydraten', 8, 2);
            $table->decimal('suiker', 8, 2);
            $table->decimal('eiwit', 8, 2);
            $table->date('datum');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('datum');
            $table->index('moment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_entries');
    }
};
