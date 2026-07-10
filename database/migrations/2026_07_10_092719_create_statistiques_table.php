<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statistiques', function (Blueprint $table) {
            $table->id('id_stat'); // clé primaire
        
            // Relation vers les services publics
            $table->foreignId('id_service')
                  ->constrained('services')
                  ->onDelete('cascade'); // si un service est supprimé, ses stats le sont aussi
        
            // Nombre de plaintes liées au service
            $table->unsignedInteger('nombre_plaintes')->default(0);
        
            // Temps moyen de résolution (en jours ou heures selon ton choix)
            $table->unsignedInteger('temps_moyen_resolution')->nullable();
        
            // Taux de satisfaction (pourcentage ou note sur 100)
            $table->decimal('taux_satisfaction', 5, 2)->nullable(); 
            // ex: 85.50 %
        
            // Dates de création et mise à jour
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistiques');
    }
};
