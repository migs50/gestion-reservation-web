<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ressources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->constrained('categories');
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nom', 120);
            $table->string('code_inv', 60)->nullable();
            $table->enum('etat', ['available', 'maintenance', 'disabled']);
            $table->boolean('actif');
            $table->string('emplacement', 120)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['etat', 'actif'], 'idx_etat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ressources');
    }
};
