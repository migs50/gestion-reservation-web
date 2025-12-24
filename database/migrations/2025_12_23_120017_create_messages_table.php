<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
