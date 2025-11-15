<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (config('database.default') === 'mysql' && Schema::hasColumn('users', 'role')) {
            DB::statement(
                "ALTER TABLE users MODIFY COLUMN role " .
                "ENUM('super_admin','admin','employer','candidate','client') " .
                "NOT NULL DEFAULT 'candidate'"
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'mysql' && Schema::hasColumn('users', 'role')) {
            DB::statement(
                "ALTER TABLE users MODIFY COLUMN role " .
                "ENUM('admin','employer','candidate','client') " .
                "NOT NULL DEFAULT 'candidate'"
            );
        }
    }
};

