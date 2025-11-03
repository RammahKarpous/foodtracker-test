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
        Schema::table('diary_entries', function (Blueprint $table) {
            $table->enum('category', ['groente', 'fruit', 'koolhydraten', 'vlees', 'noten', 'zuivel', 'kaas', 'vet', 'vocht'])->nullable()->after('product_naam');
            $table->boolean('is_red_meat')->default(false)->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diary_entries', function (Blueprint $table) {
            $table->dropColumn(['category', 'is_red_meat']);
        });
    }
};
