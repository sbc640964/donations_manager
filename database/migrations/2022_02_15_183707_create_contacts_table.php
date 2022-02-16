<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('full_name');
            $table->string('tel');
            $table->string('phone');
            $table->foreignId('shtibil_id')->nullable()->constrained('shtibils');
            $table->foreignId('city_id')->constrained('cities');
            $table->string('address');
            $table->foreignId('father_id')->nullable()->constrained('contacts');
            $table->foreignId('father_in_law_id')->nullable()->constrained('contacts');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
