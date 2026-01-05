<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->index();
            $table->string('phone');
            $table->string('company_name');

            $table->dateTime('scheduled_at');

            $table->string('status')->default('pending'); // pending|confirmed|cancelled
            $table->string('confirmation_token')->unique();
            $table->dateTime('confirmed_at')->nullable();

            // RGPD - preuve de consentement (prise de rdv)
            $table->boolean('consent')->default(false);
            $table->dateTime('consent_at')->nullable();
            $table->string('consent_ip')->nullable();
            $table->string('consent_user_agent', 512)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
