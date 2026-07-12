<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('plaintes')->where('statut', 'Enregistrée')->update(['statut' => 'En attente']);
        DB::table('plaintes')->where('statut', 'En cours')->update(['statut' => 'En cours de traitement']);

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE plaintes MODIFY statut VARCHAR(50) NOT NULL DEFAULT 'En attente'");
        }

        if (! Schema::hasTable('interventions')) {
            Schema::create('interventions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('plainte_id')->constrained('plaintes')->cascadeOnDelete();
                $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
                $table->string('type')->default('intervention');
                $table->text('description');
                $table->string('statut')->default('en_cours');
                $table->timestamp('date_debut')->nullable();
                $table->timestamp('date_fin')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasColumn('users', 'api_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('api_token', 80)->nullable()->unique()->after('remember_token');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('interventions');

        if (Schema::hasColumn('users', 'api_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('api_token');
            });
        }

        DB::table('plaintes')->where('statut', 'En attente')->update(['statut' => 'Enregistrée']);
    }
};
