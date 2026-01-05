<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'pack_id')) {
                $table->foreignId('pack_id')
                    ->nullable()
                    ->after('is_admin') // adapte si la colonne is_admin n'existe pas / est ailleurs
                    ->constrained('packs')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'pack_id')) {
                $table->dropForeign(['pack_id']);
                $table->dropColumn('pack_id');
            }
        });
    }
};
