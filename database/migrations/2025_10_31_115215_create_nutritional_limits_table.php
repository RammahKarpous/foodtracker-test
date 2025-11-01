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
        Schema::create('nutritional_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('kcal_limiet', 8, 2)->default(2000);
            $table->decimal('vet_limiet', 8, 2)->default(50);
            $table->decimal('verzadigd_limiet', 8, 2)->default(15);
            $table->decimal('koolhydraten_limiet', 8, 2)->default(220);
            $table->decimal('suiker_limiet', 8, 2)->default(30);
            $table->decimal('eiwit_limiet', 8, 2)->default(130);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutritional_limits');
    }
};
