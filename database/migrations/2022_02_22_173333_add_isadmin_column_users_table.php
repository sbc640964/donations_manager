<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsadminColumnUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('access_dashboard')->default(false);
        });
    }

    public function down()
    {
        Schema::table('', function (Blueprint $table) {
            $table->dropColumn('access_dashboard');
        });
    }
}
