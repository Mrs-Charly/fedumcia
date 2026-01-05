<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'desired_pack_id')) {
                $table->foreignId('desired_pack_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('packs')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'desired_pack_id')) {
                $table->dropForeign(['desired_pack_id']);
                $table->dropColumn('desired_pack_id');
            }
        });
    }
};
