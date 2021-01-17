<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Address extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable(false);
            $table->foreign('company_id')->references('id')->on('company')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('address')->nullable(false);
            $table->double('latitude')->nullable(false);
            $table->double('longitude')->nullable(false);
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
        Schema::drop('address');
    }
}
