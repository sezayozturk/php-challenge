<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Subscription::class,function (Faker $faker){
   $date = $faker->dateTimeBetween('-100 day')->format('Y-m-d H:i:s');
   return [
       'receipt'     => sha1($faker->randomNumber()),
       'status'      => $faker->randomElement(['started','renewed','canceled']),
       'created_at'  => $date,
       'updated_at'  => $date,
       'expire_date' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date)->add('+30day'),
   ];
});
