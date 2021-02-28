<?php

use App\Models\Device;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        $devices = Device::all();
        foreach ($devices as $device) {
            factory(Subscription::class)->create([
                'device_id' => $device->id,
            ]);
        }
    }
}
