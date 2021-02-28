<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
	{
		public function up()
			{
				Schema::create('subscriptions',function(Blueprint $table){
					$table->id();

					$table->unsignedBigInteger('device_id')->nullable();
					$table->string('receipt',100);
					$table->string('expire_date',100);
					$table->string('status',20)->comment('started-renewed-canceled')->nullable();

					$table->timestamps();

					$table->foreign('device_id')->references('id')->on('devices');
					$table->unique('device_id');
				});
			}

		public function down()
			{
				Schema::dropIfExists('subscriptions');
			}
	}
