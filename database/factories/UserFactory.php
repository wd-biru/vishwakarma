<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

// $factory->define(App\User::class, function (Faker $faker) {
//     static $password;
//
//     return [
//         'name' => $faker->name,
//         'email' => $faker->unique()->safeEmail,
//         'password' => $password ?: $password = bcrypt('secret'),
//         'remember_token' => str_random(10),
//     ];
// });



$factory->define(App\Models\VishwaServiceRegistration::class, function (Faker $faker) {


    return [
      'service_group_ids'=> $faker->randomDigit(7),
      'service_ids' => $faker->randomDigit(7),
      'company_name' => $faker->company,
      'company_address' => $faker->address,
      'cityid' => $faker->randomDigit(7),
      'stateid' => $faker->randomDigit(7),
      'pincode' => $faker->randomDigit(6),
      'phone_no' => $faker->randomDigit(8),
      'mobile' => $faker->randomDigit(10),
      'email' => $faker->unique()->safeEmail,
      'website' => $faker->name,
      'contact_name' => $faker->name,
      'contact_mobile' => $faker->randomDigit(10),
      'contact_email' => $faker->unique()->safeEmail,
      'aadhar_no' => str_random(16),
      'financial_turnover' => $faker->randomDigit(12),
      'yearly_income' => $faker->randomDigit(7),
      'is_active' => 1,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now(),
    ];
});


$factory->define(App\Models\VishwaServiceRegistrationDocs::class, function (Faker $faker) {
    static $password;

    return [
        'aadhar_file' => $faker->Image,
        'pan_no_file' => $faker->Image,
        'gst_file' => $faker->Image,
        'is_active' =>1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});

$factory->define(App\Models\VishwaServiceRegistrationProjects::class, function (Faker $faker) {
    static $password;

    return [
        'project_name' => str_random(30),
        'project_type' => str_random(15),
        'project_location' => str_random(15),
        'is_active' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
