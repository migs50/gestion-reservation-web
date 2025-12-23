<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->foreignId('reservation_id')->constrained('reservations')->cascadeOnDelete();
            $table->foreignId('ressource_id')->constrained('ressources')->cascadeOnDelete();
            $table->dateTime('debut_prevu')->nullable();
            $table->dateTime('fin_prevue')->nullable();
            $table->dateTime('debut_reel')->nullable();
            $table->dateTime('fin_reel')->nullable();
            $table->enum('statut', ['planned', 'active', 'finished']);

            $table->primary(['reservation_id', 'ressource_id']);
            $table->index(['ressource_id', 'statut', 'debut_prevu', 'fin_prevue'], 'idx_res_planning');
            $table->index(['ressource_id', 'statut', 'debut_reel', 'fin_reel'], 'idx_res_reel');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
