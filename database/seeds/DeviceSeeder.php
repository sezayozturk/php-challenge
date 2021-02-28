<?php

use App\Models\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
	{
		public function run()
			{
                factory(Device::class, 500)->create();
			}
	}
