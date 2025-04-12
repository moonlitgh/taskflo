<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'profile_picture')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_picture')->nullable()->after('password');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'profile_picture')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('profile_picture');
            });
        }
    }
}; 