<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Expand enum to include both old and new values so existing rows remain valid
        DB::statement("
            ALTER TABLE diary_entries
            MODIFY category ENUM(
                'groente',
                'fruit',
                'koolhydraten',
                'vlees',
                'noten',
                'zuivel',
                'kaas',
                'vet',
                'bereidingsvet',
                'margarine',
                'onbekend',
                'vocht'
            ) NULL
        ");

        // 2) Migrate data: map old 'vet' to new 'bereidingsvet'
        DB::statement("UPDATE diary_entries SET category = 'bereidingsvet' WHERE category = 'vet'");

        // 3) Shrink enum to remove 'vet'
        DB::statement("
            ALTER TABLE diary_entries
            MODIFY category ENUM(
                'groente',
                'fruit',
                'koolhydraten',
                'vlees',
                'noten',
                'zuivel',
                'kaas',
                'bereidingsvet',
                'margarine',
                'onbekend',
                'vocht'
            ) NULL
        ");
    }

    public function down(): void
    {
        // Reverse: map 'bereidingsvet' back to 'vet', and set values not supported previously to NULL
        DB::statement("UPDATE diary_entries SET category = 'vet' WHERE category = 'bereidingsvet'");
        DB::statement("UPDATE diary_entries SET category = NULL WHERE category IN ('margarine', 'onbekend')");

        DB::statement("
            ALTER TABLE diary_entries
            MODIFY category ENUM(
                'groente',
                'fruit',
                'koolhydraten',
                'vlees',
                'noten',
                'zuivel',
                'kaas',
                'vet',
                'vocht'
            ) NULL
        ");
    }
};


