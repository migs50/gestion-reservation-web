<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ressource_id')->nullable()->constrained('ressources')->nullOnDelete();
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->nullOnDelete();
            $table->foreignId('createur_id')->constrained('users');
            $table->enum('statut', ['open', 'closed']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
