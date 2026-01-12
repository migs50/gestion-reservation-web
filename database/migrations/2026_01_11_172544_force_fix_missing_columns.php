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
            if (!Schema::hasColumn('notifications', 'lien')) {
                $table->string('lien')->nullable()->after('contenu');
            }
        });

        Schema::table('demande_comptes', function (Blueprint $table) {
            if (!Schema::hasColumn('demande_comptes', 'password')) {
                $table->string('password')->nullable()->after('justification');
            }
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'lien')) {
                $table->dropColumn('lien');
            }
        });

        Schema::table('demande_comptes', function (Blueprint $table) {
            if (Schema::hasColumn('demande_comptes', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
};
