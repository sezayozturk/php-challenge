<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AppSeeder::class);
        $this->call(DeviceSeeder::class);
        $this->call(SubscriptionSeeder::class);
    }
}
