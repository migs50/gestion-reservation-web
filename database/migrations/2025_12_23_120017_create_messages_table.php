<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->nullable()->constrained('discussions')->nullOnDelete();
            $table->foreignId('incident_id')->nullable()->constrained('incidents')->nullOnDelete();
            $table->foreignId('auteur_id')->constrained('users');
            $table->text('contenu');
            $table->boolean('cache');
            $table->timestamps();

            $table->index('discussion_id', 'idx_disc');
            $table->index('incident_id', 'idx_inc');
            $table->index('auteur_id', 'idx_auteur');
        });

        DB::statement("ALTER TABLE messages ADD CONSTRAINT ck_canal CHECK ((discussion_id IS NULL) <> (incident_id IS NULL))");
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
