<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('declarant_id')->constrained('users');
            $table->foreignId('ressource_id')->nullable()->constrained('ressources')->nullOnDelete();
            $table->foreignId('assigne_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('titre', 140);
            $table->text('description');
            $table->enum('statut', ['open', 'in_progress', 'resolved', 'closed']);
            $table->timestamps();

            $table->index('statut', 'idx_statut');
            $table->index('ressource_id', 'idx_res');
            $table->index('assigne_id', 'idx_assigne');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
