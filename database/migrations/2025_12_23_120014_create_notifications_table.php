<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['decision', 'expiration', 'conflit', 'maintenance', 'message', 'incident']);
            $table->string('titre', 140);
            $table->text('contenu');
            $table->boolean('lu');
            $table->timestamps();

            $table->index(['user_id', 'lu'], 'idx_user_lu');
            $table->index('type', 'idx_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
