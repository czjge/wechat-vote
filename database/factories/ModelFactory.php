<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\vote\Wxuser::class, function (Faker\Generator $faker) {
    $faker->addProvider(new App\Extensions\faker\Wxuser($faker));
    return [
        'openid'     => 'oBE6Bw'.str_random(22),
        'subscribe'  => 1,
        'nickname'   => $faker->name,
        'sex'        => $faker->numberBetween(0, 2),
        'province'   => $faker->province,
        'city'       => $faker->city,
        'country'    => $faker->country,
        'headimgurl' => 'http://wx.qlogo.cn/mmopen/9myrSSFodlxibCkUulfSDBGEdkvfnA2BT7VMDgHlXcuibRichZ3mrIEAzOLrt6XnTic4SmueOLvzTOdP6Evib6DCdYT43gS96ZJPR/0',
        'ctime'      => time(),
    ];
});
