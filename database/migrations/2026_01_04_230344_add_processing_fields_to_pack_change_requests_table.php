<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pack_change_requests', function (Blueprint $table) {

            if (!Schema::hasColumn('pack_change_requests', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('admin_comment');
            }

            if (!Schema::hasColumn('pack_change_requests', 'processed_by')) {
                $table->foreignId('processed_by')
                    ->nullable()
                    ->after('approved_at')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pack_change_requests', function (Blueprint $table) {
            if (Schema::hasColumn('pack_change_requests', 'processed_by')) {
                $table->dropForeign(['processed_by']);
                $table->dropColumn('processed_by');
            }

            if (Schema::hasColumn('pack_change_requests', 'approved_at')) {
                $table->dropColumn('approved_at');
            }
        });
    }
};
