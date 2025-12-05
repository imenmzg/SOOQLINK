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
            DB::statement('ALTER TABLE products ALTER COLUMN name TYPE json USING CASE WHEN name IS NULL THEN NULL ELSE json_build_object(\'ar\', name) END');
            DB::statement('ALTER TABLE products ALTER COLUMN description TYPE json USING CASE WHEN description IS NULL THEN NULL ELSE json_build_object(\'ar\', description) END');
            DB::statement('ALTER TABLE products ALTER COLUMN technical_details TYPE json USING CASE WHEN technical_details IS NULL THEN NULL ELSE json_build_object(\'ar\', technical_details) END');
        } else {
            Schema::table('products', function (Blueprint $table) {
                // Change name, description, and technical_details to JSON for translations
                $table->json('name')->change();
                $table->json('description')->nullable()->change();
                $table->json('technical_details')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->change();
            $table->text('description')->nullable()->change();
            $table->text('technical_details')->nullable()->change();
        });
    }
};
