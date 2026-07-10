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
     Schema::create('notifications', function (Blueprint $table) {
      $table->id('id_notification'); // clé primaire

      // Relations
      $table->foreignId('id_user')
            ->constrained('users')
            ->onDelete('cascade'); // si l’utilisateur est supprimé, on supprime ses notifications
  
      $table->foreignId('id_plainte')
            ->constrained('plaintes')
            ->onDelete('cascade'); // si la plainte est supprimée, on supprime ses notifications
  
      // Type de notification
      $table->enum('type', ['email', 'SMS', 'in-app']);
  
      // Contenu
      $table->text('content');
  
      // Statut
      $table->enum('status', ['sent', 'read'])->default('sent');
  
      // Date de création
      $table->timestamps(); // created_at et updated_at
     })  ;

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
