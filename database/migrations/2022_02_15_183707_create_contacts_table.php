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
            $table->foreignId('shtibil')->nullable()->constrained('shtibils');
            $table->foreignId('city')->constrained('cities');
            $table->string('address');
            $table->foreignId('father')->nullable()->constrained('contacts');
            $table->foreignId('father_in_law')->nullable()->constrained('contacts');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
