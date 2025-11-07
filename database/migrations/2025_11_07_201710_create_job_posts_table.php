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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->longText('responsibilities')->nullable();
            $table->string('location')->nullable();
            $table->enum('work_type', ['remote','on-site','hybrid'])->default('on-site');
            $table->unsignedInteger('salary_min')->nullable();
            $table->unsignedInteger('salary_max')->nullable();
            $table->string('currency', 8)->default('USD');
            $table->string('experience_level')->nullable();
            $table->json('technologies')->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('application_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
