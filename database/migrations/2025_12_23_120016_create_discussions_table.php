<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

            $table->index('ressource_id', 'idx_res');
            $table->index('reservation_id', 'idx_resa');
            $table->index('createur_id', 'idx_createur');
        });

        DB::statement("ALTER TABLE discussions ADD CONSTRAINT ck_lien CHECK ((ressource_id IS NULL) <> (reservation_id IS NULL))");
    }

    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
