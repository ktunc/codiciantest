<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Person extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable(false);
            $table->foreign('company_id')->references('id')->on('company')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('phone')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('person');
    }
}
