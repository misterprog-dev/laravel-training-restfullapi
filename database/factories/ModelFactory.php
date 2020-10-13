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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElements([\App\User::UNVERIFIED_USER, \App\User::VERIFIED_USER]),
        'verification_token' => $verified == \App\User::VERIFIED_USER ? null : \App\User::generateVerificationCode(),
        'admin' => $verified = $faker->randomElements([\App\User::REGULAR_USER, \App\User::ADMIN_USER]),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1)
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1, 10),
        'status' => $faker->randomElements([\App\Product::UNAVAILABLE_PRODUCT, \App\Product::AVAILABLE_PRODUCT]),
        'image' => $faker->randomElements(['product1.png','product2.png', 'product3.png', 'product4.jpg', 'product5.jpg']),
        'seller_id' => \App\User::all()->random()->id
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Transaction::class, function (Faker\Generator $faker) {

    $seller = \App\Seller::has('products')->get()->random();
    $buyer = \App\User::all()->except($seller->id)->random();

    return [
        'quantity' => $faker->numberBetween(1,3),
        'buyer_id' => $buyer->id,
        'product_id' => $seller->products->random()->id
    ];
});
