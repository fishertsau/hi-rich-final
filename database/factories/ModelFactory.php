<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Site;
use App\Models\Link;
use App\Models\News;
use App\Models\Photo;
use App\Models\About;
use App\Models\Ad;
use App\Models\Product;
use App\Models\Contact;
use App\Models\WebConfig;
use App\Models\Category\LinkCategory;
use App\Models\Category\NewsCategory;
use App\Models\Category\ProductCategory;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(About::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(3),
        'body' => "<p>{$faker->text(1500)}</p>",
        'published' => false
    ];
});


$factory->define(ProductCategory::class, function (Faker\Generator $faker) {
    return [
        'activated' => true,
        'title' => $faker->name,
        'description' => 'CategoryDescription',
        'level' => 1
    ];
});


$factory->define(Product::class, function (Faker\Generator $faker) {
    return [
        'title' => "中文名稱" . $faker->text(5),
        'title_en' => "英文名稱" . $faker->text(5),
        'published' => true,
        'cat_id' => function () {
            return create(ProductCategory::class)->id;
        },
        'body' => "產品內容" . $faker->paragraph(2),
    ];
});

$factory->state(Product::class, 'published', function () {
    return [
        'published' => true
    ];
});

$factory->state(Product::class, 'unpublished', function () {
    return [
        'published' => false
    ];
});

$factory->define(Photo::class, function () {
    return [
        'photoable_id' => 1,
        'photoable_type' => 'SomePhotoableModel',
    ];
});

$factory->define(Contact::class, function () {
    return [
        'title' => 'title',
        'email' => 'john@example.com',
        'contact' => 'contact',
        'address' => 'address',
        'tel' => '22226666',
        'message' => 'AMessage',
        'company_name' => 'company_name',
    ];
});

$factory->define(NewsCategory::class, function (Faker\Generator $faker) {
    return [
        'activated' => true,
        'title' => $faker->name,
        'description' => 'CategoryDescription',
        'level' => 1
    ];
});

$factory->define(News::class, function (Faker\Generator $faker) {
    return [
        'cat_id' => $faker->numberBetween(1, count(NewsCategory::main()->get())),
        'title' => $faker->name,
        'body' => "<p>{$faker->paragraph}</p>",
        'published_until' => $faker->dateTime(),
        'published_since' => $faker->dateTime()
    ];
});

$factory->define(WebConfig::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(Site::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'tel' => $faker->phoneNumber,
        'fax' => $faker->phoneNumber,
        'ranking' => count(Site::all()) + 1,
        'published' => true
    ];
});

$factory->define(LinkCategory::class, function (Faker\Generator $faker) {
    return [
        'activated' => true,
        'title' => $faker->name,
        'description' => 'CategoryDescription',
        'level' => 1
    ];
});

$factory->define(Link::class, function (Faker\Generator $faker) {
    return [
        'cat_id' => (LinkCategory::main()->get())[0]->id,
        'title' => $faker->name,
        'url' => $faker->domainName
    ];
});

$factory->define(Ad::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'location' => 1,
        'ranking' => count(Ad::all()) + 1,
        'published' => true
    ];
});
