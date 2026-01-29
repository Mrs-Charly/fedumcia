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
        Schema::create('portfolio_projects', function (\Illuminate\Database\Schema\Blueprint $table) {
    $table->id();

    $table->string('title');
    $table->string('slug')->unique();

    $table->string('client')->nullable(); // ex: Club de Hand
    $table->string('category')->nullable(); // ex: Photo/Video, Branding, Réseaux
    $table->text('excerpt')->nullable();
    $table->longText('content')->nullable();

    $table->string('cover_path')->nullable(); // image principale (storage)
    $table->json('gallery_paths')->nullable(); // liste d’images (storage)

    $table->string('website_url')->nullable();
    $table->string('instagram_url')->nullable();
    $table->string('facebook_url')->nullable();
    $table->string('tiktok_url')->nullable();
    $table->string('linkedin_url')->nullable();

    $table->boolean('is_active')->default(true);
    $table->unsignedInteger('sort_order')->default(0);

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_projects');
    }
};
