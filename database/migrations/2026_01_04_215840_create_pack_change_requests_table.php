<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pack_change_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_pack_id')->nullable()->constrained('packs')->nullOnDelete();

            $table->string('status')->default('pending'); // pending|approved|rejected|cancelled
            $table->text('message')->nullable();          // message user (optionnel)
            $table->text('admin_note')->nullable();       // note interne (optionnel)

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete(); // admin

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pack_change_requests');
    }
};
