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
        Schema::create('onas_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('EN COURS');
            $table->string('start_label')->nullable();
            $table->string('end_label')->nullable();
            $table->string('due_label')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->string('cover_image')->nullable();
            $table->string('cover_image_mobile')->nullable();
            $table->text('objective')->nullable();
            $table->json('timeline_intro')->nullable();
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
        Schema::dropIfExists('onas_projects');
    }
};
