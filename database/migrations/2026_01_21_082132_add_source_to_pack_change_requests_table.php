<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('pack_change_requests', function (Blueprint $table) {
        $table->string('source', 50)->nullable()->after('message'); // 'user_request' | 'appointment' | 'admin_direct'
    });
}

public function down(): void
{
    Schema::table('pack_change_requests', function (Blueprint $table) {
        $table->dropColumn('source');
    });
}

};
