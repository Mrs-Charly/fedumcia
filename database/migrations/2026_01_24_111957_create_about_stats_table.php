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
        Schema::create('about_stats', function (\Illuminate\Database\Schema\Blueprint $table) {
    $table->id();
    $table->string('label');         // ex: "Vêtements personnalisés vendus"
    $table->string('value');         // ex: "120+"
    $table->string('note')->nullable(); // ex: "sur 12 mois"
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
        Schema::dropIfExists('about_stats');
    }
};
