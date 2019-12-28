<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\About;
use App\Models\Contact;
use App\Models\Service;
use App\User;
use App\Models\News;
use App\Models\Photo;
use App\Models\Sample;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Category;
use App\Models\WebConfig;

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


$factory->define(Category::class, function (Faker\Generator $faker) {
    return [
        'activated' => true,
        'title' => $faker->name,
        'description' => 'CategoryDescription',
        'description_en' => 'EnglishCategoryDescription',
        'level' => 1
    ];
});


$factory->define(Product::class, function (Faker\Generator $faker) {
    return [
        'title' => "pro_$faker->name",
        'title_en' => 'English Name',
        'published' => true,
        'published_in_home' => true,
        'cat_id' => function () {
            return create(Category::class)->id;
        },
        'body' => $faker->paragraph(2),
        'body_en' => $faker->paragraph(2),
        'briefing' => $faker->paragraph(2),
        'briefing_en' => $faker->paragraph(2)
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

// todo: remove this
$factory->define(Inquiry::class, function () {
    return [
        'subject' => 'ANewSubject',
        'email' => 'john@example.com',
        'tel' => '22226666',
        'message' => 'AMessage',
        'company_name' => 'company_name',
        'material' => 'material',
        'purpose' => 'purpose',
        'spec' => 'spec',
        'estimated_qty' => 'estimated_qty',
        'viscosity' => 'viscosity',
        'surface_treatment' => 'surface_treatment',
        'packing' => 'packing',
        'print_out' => 'print_out'
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

// todo: remove this
$factory->define(Sample::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'published' => true,
        'body' => $faker->paragraph(30),
        'description' => $faker->sentence(10)
    ];
});


$factory->define(News::class, function (Faker\Generator $faker) {
    return [
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

$factory->define(Service::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->title,
        'body' => $faker->text(),
        'published' => false,
        'published_in_home' => false,
    ];
});