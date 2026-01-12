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
        Schema::table('ressources', function (Blueprint $table) {
            $table->string('cpu')->nullable()->after('description');
            $table->string('ram')->nullable()->after('cpu');
            $table->string('os')->nullable()->after('ram');
            $table->string('bande_passante')->nullable()->after('os');
            $table->string('capacite')->nullable()->after('bande_passante');
            $table->string('type_stockage')->nullable()->after('capacite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ressources', function (Blueprint $table) {
            $table->dropColumn(['cpu', 'ram', 'os', 'bande_passante', 'capacite', 'type_stockage']);
        });
    }
};
