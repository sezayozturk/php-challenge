<?php

use App\Models\App;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
	{
		public function run()
			{
                factory(App::class, 20)->create();
			}
	}
