<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demande_comptes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_complet', 150);
            $table->string('email', 191);
            $table->string('telephone', 30);
            $table->enum('type_demande', ['Interne', 'Responsable']);
            $table->text('justification');
            $table->string('password')->nullable();
            $table->enum('statut', ['pending', 'approved', 'refused']);
            $table->foreignId('decided_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note_decision')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demande_comptes');
    }
};
