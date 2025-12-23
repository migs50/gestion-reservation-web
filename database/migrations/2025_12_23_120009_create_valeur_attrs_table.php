<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valeur_attrs', function (Blueprint $table) {
            $table->foreignId('ressource_id')->constrained('ressources')->cascadeOnDelete();
            $table->foreignId('attribut_id')->constrained('attributs')->cascadeOnDelete();
            $table->string('v_string', 255)->nullable();
            $table->decimal('v_number', 18, 4)->nullable();
            $table->boolean('v_bool')->nullable();
            $table->date('v_date')->nullable();

            $table->primary(['ressource_id', 'attribut_id']);
            $table->index('attribut_id', 'idx_attr');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valeur_attrs');
    }
};
