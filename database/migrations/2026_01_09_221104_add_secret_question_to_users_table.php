<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'secret_question')) {
                $table->string('secret_question', 255)->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'secret_answer')) {
                $table->string('secret_answer', 255)->nullable()->after('secret_question');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['secret_question', 'secret_answer']);
        });
    }
};