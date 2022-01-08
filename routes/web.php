<?php

use App\Models\Product;
use Faker\Factory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('get-product', function () {
    return Product::all();
});
Route::get('create-product', function () {
    $faker = Factory::create();
    $product = Product::create([
        'name' => $faker->sentence(rand(1, 2)),
        'slug' => $faker->slug(rand(1, 2)),
        'desc' => $faker->paragraph(rand(1, 6)),
        'price' => rand(111111, 99999),
    ]);

    return $product;
});
