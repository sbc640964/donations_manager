<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShtibilsTable extends Migration
{
    public function up()
    {
        Schema::create('shtibils', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->foreignId('city_id')->constrained('cities');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shtibiles');
    }
}
