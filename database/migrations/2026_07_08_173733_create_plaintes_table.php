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
        Schema::create('plaintes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            $table->foreignId('id_service')
                ->nullable()
                ->constrained('services')
                ->onDelete('set null');

            $table->string('title');
            $table->text('description');
            $table->string('piece_jointe')->nullable();
            $table->enum('statut', ['Enregistrée', 'En cours', 'Résolue', 'Rejetée'])
                  ->default('Enregistrée');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plaintes');
    }
};
