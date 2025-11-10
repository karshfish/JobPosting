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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('responsibilities')->nullable();
            $table->json('skills')->nullable();
            $table->json('qualifications')->nullable();
            $table->string('salary_range')->nullable();
            $table->text('benefits')->nullable();
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->enum('work_type', ['remote', 'on-site', 'hybrid'])->default('on-site');
            $table->string('branding_image')->nullable();
            $table->date('application_deadline')->nullable();
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');            $table->timestamps();
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
