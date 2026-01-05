<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pack_change_requests', function (Blueprint $table) {

            // Utilisateur demandeur
            if (!Schema::hasColumn('pack_change_requests', 'user_id')) {
                $table->foreignId('user_id')
                    ->after('id')
                    ->constrained()
                    ->cascadeOnDelete();
            }

            // Pack actuel
            if (!Schema::hasColumn('pack_change_requests', 'current_pack_id')) {
                $table->foreignId('current_pack_id')
                    ->nullable()
                    ->constrained('packs')
                    ->nullOnDelete();
            }

            // Pack demandé
            if (!Schema::hasColumn('pack_change_requests', 'requested_pack_id')) {
                $table->foreignId('requested_pack_id')
                    ->constrained('packs')
                    ->cascadeOnDelete();
            }

            // Statut
            if (!Schema::hasColumn('pack_change_requests', 'status')) {
                $table->string('status')->default('pending');
            }

            // Commentaire admin
            if (!Schema::hasColumn('pack_change_requests', 'admin_comment')) {
                $table->text('admin_comment')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pack_change_requests', function (Blueprint $table) {
            $table->dropColumn([
                'user_id',
                'current_pack_id',
                'requested_pack_id',
                'status',
                'admin_comment',
            ]);
        });
    }
};
