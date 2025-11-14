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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('status')->default('DRAFT');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('objectif')->nullable();
            $table->longText('intro')->nullable();
            $table->string('youtube_id')->nullable();
            $table->text('files_note')->nullable();
            $table->json('contact')->nullable();
            $table->json('news')->nullable();
            $table->json('timeline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
