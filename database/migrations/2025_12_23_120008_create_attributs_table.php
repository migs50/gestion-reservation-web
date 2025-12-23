<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attributs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->constrained('categories');
            $table->string('nom', 80);
            $table->enum('type_valeur', ['string', 'number', 'boolean', 'date']);
            $table->string('unite', 20)->nullable();
            $table->timestamps();

            $table->unique(['categorie_id', 'nom'], 'uq_cat_nom');
            $table->index('categorie_id', 'idx_cat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attributs');
    }
};
