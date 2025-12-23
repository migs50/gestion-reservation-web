<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moderations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('messages')->cascadeOnDelete();
            $table->foreignId('moderateur_id')->constrained('users');
            $table->enum('action', ['hide', 'restore', 'warn']);
            $table->text('raison')->nullable();
            $table->timestamps();

            $table->index('message_id', 'idx_msg');
            $table->index('moderateur_id', 'idx_mod');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moderations');
    }
};
