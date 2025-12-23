<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_perms', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('perm_id')->constrained('permissions');

            $table->primary(['role_id', 'perm_id']);
            $table->index('perm_id', 'idx_perm');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_perms');
    }
};
