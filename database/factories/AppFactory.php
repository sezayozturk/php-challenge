<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Models\App::class,function (Faker $faker){
    return [
        'name'          => 'App '.Str::upper($faker->word(20)),
        'ios_app_id'    => $faker->numberBetween($min = 10000000000, $max = 90000000000),
        'google_app_id' => $faker->numberBetween($min = 10000000000, $max = 90000000000),
        'username'      => 'username',
        'password'      => '123456',
        'callback_url'  => url('/api/3rd-party-app/send'),
        'status'        => 1,
    ];
});
