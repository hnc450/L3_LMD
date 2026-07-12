<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('id_service')->nullable()->after('id_role')->constrained('services')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->after('id_service')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_service']);
            $table->dropForeign(['created_by']);
            $table->dropColumn(['id_service', 'created_by']);
        });
    }
};
