<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (! Schema::hasColumn('companies', 'name')) {
                $table->string('name');
            }
            if (! Schema::hasColumn('companies', 'slug')) {
                $table->string('slug')->unique();
            }
            if (! Schema::hasColumn('companies', 'website')) {
                $table->string('website')->nullable();
            }
            if (! Schema::hasColumn('companies', 'email')) {
                $table->string('email')->nullable();
            }
            if (! Schema::hasColumn('companies', 'location')) {
                $table->string('location')->nullable();
            }
            if (! Schema::hasColumn('companies', 'logo_path')) {
                $table->string('logo_path')->nullable();
            }
            if (! Schema::hasColumn('companies', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'slug')) {
                $table->dropUnique('companies_slug_unique');
                $table->dropColumn('slug');
            }
            foreach (['name','website','email','location','logo_path','description'] as $col) {
                if (Schema::hasColumn('companies', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};

