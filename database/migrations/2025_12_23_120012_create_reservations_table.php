<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demandeur_id')->constrained('users');
            $table->foreignId('ressource_id')->constrained('ressources'); //UPDATED BY ADAM (ressource_ID ets aussi ajoutees au app\models\reservation.php
            $table->foreignId('decideur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('debut');
            $table->dateTime('fin');
            $table->text('justification');
            $table->enum('statut', ['pending', 'approved', 'refused', 'active', 'finished', 'cancelled']);
            $table->text('note_decision')->nullable();
            $table->timestamps();

            $table->index(['demandeur_id', 'statut'], 'idx_dem');
            $table->index('decideur_id', 'idx_dec');
            $table->index(['debut', 'fin'], 'idx_dates');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};