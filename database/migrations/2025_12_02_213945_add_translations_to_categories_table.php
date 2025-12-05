<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For PostgreSQL, we need to convert string to JSON explicitly
        if (config('database.default') === 'pgsql') {
            // Convert existing string values to JSON format
            DB::statement('ALTER TABLE categories ALTER COLUMN name TYPE json USING CASE WHEN name IS NULL THEN NULL ELSE json_build_object(\'ar\', name) END');
            DB::statement('ALTER TABLE categories ALTER COLUMN description TYPE json USING CASE WHEN description IS NULL THEN NULL ELSE json_build_object(\'ar\', description) END');
        } else {
            Schema::table('categories', function (Blueprint $table) {
                // Change name and description to JSON for translations
                $table->json('name')->change();
                $table->json('description')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->change();
            $table->text('description')->nullable()->change();
        });
    }
};
