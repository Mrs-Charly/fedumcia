<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pack_change_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('pack_change_requests', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('approved_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pack_change_requests', function (Blueprint $table) {
            if (Schema::hasColumn('pack_change_requests', 'rejected_at')) {
                $table->dropColumn('rejected_at');
            }
        });
    }
};
