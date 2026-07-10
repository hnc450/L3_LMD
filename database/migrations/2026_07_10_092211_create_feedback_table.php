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
      Schema::create('feedback', function (Blueprint $table) {
          $table->id('id_feedback'); // clé primaire
      
          // Relations
          $table->foreignId('id_plainte')
                ->constrained('plaintes')
                ->onDelete('cascade'); // si la plainte est supprimée, on supprime le feedback
      
          $table->foreignId('id_user')
                ->constrained('users')
                ->onDelete('cascade'); // si l’utilisateur est supprimé, on supprime son feedback
      
          // Note (1 à 5)
          $table->unsignedTinyInteger('note'); // valeur entière entre 1 et 5
      
          // Commentaire
          $table->text('comment')->nullable();
      
          // Date de création
          $table->timestamps(); // created_at et updated_at
      });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
