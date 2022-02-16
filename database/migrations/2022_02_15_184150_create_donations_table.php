<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->integer('amount');
            $table->integer('months')->default(1);
            $table->foreignId('donor_id')->constrained('contacts');
            $table->foreignId('fund_raiser_id')->constrained('contacts');
            $table->text('file')->nullable();
            $table->boolean('done')->default(false);
            $table->text('not')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
