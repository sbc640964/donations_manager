<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMonthsColumnDonationTable extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->integer('months')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->integer('months')->change();
        });
    }
}
