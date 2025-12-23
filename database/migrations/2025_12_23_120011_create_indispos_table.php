<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indispos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ressource_id')->constrained('ressources');
            $table->foreignId('created_by')->constrained('users');
            $table->enum('type', ['maintenance', 'panne', 'autre']);
            $table->dateTime('debut');
            $table->dateTime('fin');
            $table->text('raison');
            $table->boolean('actif');
            $table->timestamps();

            $table->index(['ressource_id', 'actif', 'debut', 'fin'], 'idx_res_dates');
            $table->index('type', 'idx_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indispos');
    }
};
