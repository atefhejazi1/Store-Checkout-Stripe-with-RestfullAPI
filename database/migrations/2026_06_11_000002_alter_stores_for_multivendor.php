<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('business_phone')->nullable()->after('description');
            $table->json('payout_details')->nullable()->after('business_phone');

            $table->enum('vendor_status', ['pending', 'approved', 'blocked'])
                  ->default('pending')
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'business_phone', 'payout_details', 'vendor_status']);
        });
    }
};
