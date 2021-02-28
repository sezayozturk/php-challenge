<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppsTable extends Migration
{
    public function up()
    {
        Schema::create('apps',function (Blueprint $table){
            $table->id();
            $table->string('name',100);

            $table->string('ios_app_id',100)->nullable();
            $table->string('google_app_id',100)->nullable();

            $table->string('username',60)->nullable();
            $table->string('password',60)->nullable();

            $table->string('callback_url',200)->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('apps');
    }
}
