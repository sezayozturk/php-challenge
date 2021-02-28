<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(\App\Models\Device::class,function (Faker $faker){
    $created_at = $faker->dateTimeBetween('-30 day');
    return [
        'app_id'       => \App\Models\App::select('id')->get()->random()->id,
        'u_id'         => $faker->uuid,
        'os'           => $faker->randomNumber() % 2 ? 'ios' : 'android',
        'lang'         => 'tr',
        'client_token' => sha1($faker->randomNumber()),
        'created_at'   => $created_at,
        'updated_at'   => $created_at,
    ];
});
