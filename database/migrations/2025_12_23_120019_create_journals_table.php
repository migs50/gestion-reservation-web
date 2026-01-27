<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('journals')) {
            Schema::create('journals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('acteur_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('action', 120);
                $table->string('objet', 80)->nullable();
                $table->unsignedBigInteger('objet_id')->nullable();
                $table->text('details')->nullable();
                $table->json('donnees')->nullable();
                $table->string('ip', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();

                $table->index(['objet', 'objet_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
