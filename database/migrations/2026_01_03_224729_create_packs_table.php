<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // Pack Start / Croissance / Premium
            $table->string('slug')->unique();       // start / croissance / premium
            $table->unsignedInteger('price_eur');   // 200 / 500 / 800
            $table->string('tagline')->nullable();  // "L'essentiel pour être visible"
            $table->text('short_description')->nullable();
            $table->longText('details')->nullable(); // contenu détaillé (texte)
            $table->unsignedSmallInteger('posts_per_month')->nullable(); // 8/12/24
            $table->unsignedSmallInteger('review_response_hours')->nullable(); // 48/24/12
            $table->unsignedSmallInteger('sort_order')->default(0); // ordre d’affichage
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packs');
    }
};
