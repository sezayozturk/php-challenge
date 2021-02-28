<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    public function up()
    {
        Schema::create('devices',function (Blueprint $table){
            $table->id();

            $table->unsignedBigInteger('app_id');
            $table->string('u_id',100);
            $table->string('os',10);
            $table->string('lang',10)->default('en');
            $table->string('client_token',100);

            $table->timestamps();

            $table->foreign('app_id')->references('id')->on('apps');
            $table->unique(['app_id','u_id']);
            $table->index(['app_id','client_token']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
