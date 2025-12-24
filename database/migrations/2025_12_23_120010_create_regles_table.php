<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('auteur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('titre', 120);
            $table->text('contenu');
            $table->boolean('actif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regles');
    }
};
