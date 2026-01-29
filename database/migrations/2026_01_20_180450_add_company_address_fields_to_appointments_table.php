<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('company_address')->nullable()->after('company_name');
            $table->string('company_postal_code', 20)->nullable()->after('company_address');
            $table->string('company_city')->nullable()->after('company_postal_code');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['company_address', 'company_postal_code', 'company_city']);
        });
    }
};
