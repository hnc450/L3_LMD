<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plaintes', function (Blueprint $table) {
            $table->string('code_suivi')->unique()->nullable()->after('id');
            $table->foreignId('agent_id')->nullable()->after('id_service')->constrained('users')->nullOnDelete();
            $table->string('contact_nom')->nullable()->after('agent_id');
            $table->string('contact_info')->nullable()->after('contact_nom');
            $table->enum('priorite', ['normale', 'haute', 'urgente'])->default('normale')->after('statut');
        });
    }

    public function down(): void
    {
        Schema::table('plaintes', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropColumn(['code_suivi', 'agent_id', 'contact_nom', 'contact_info', 'priorite']);
        });
    }
};
