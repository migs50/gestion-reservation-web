<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Change the 'type' column from enum to string to allow more values like 'decision_responsable'
            $table->string('type', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Revert back to enum if needed, though this might fail if data contains values not in enum
            // Ideally we would map them or truncate, but for strict down:
            //$table->enum('type', ['decision', 'expiration', 'conflit', 'maintenance', 'message', 'incident'])->change();
        });
    }
};
