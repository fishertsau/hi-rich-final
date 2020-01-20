let mix = require('laravel-mix');
// 管理後台
mix.js('resources/assets/js/system/category/categoryIndex.js', 'public/js/system/category');
mix.js('resources/assets/js/system/category/categoryCreate.js', 'public/js/system/category');

mix.js('resources/assets/js/system/product/productCreate.js', 'public/js/system/product');
mix.js('resources/assets/js/system/product/productIndex.js', 'public/js/system/product');

mix.js('resources/assets/js/system/contact/contactShow.js', 'public/js/system/contact');

mix.js('resources/assets/js/system/news/newsIndex.js', 'public/js/system/news');

mix.js('resources/assets/js/system/sites/index.js', 'public/js/system/sites');

mix.js('resources/assets/js/system/links/index.js', 'public/js/system/links');
mix.js('resources/assets/js/system/links/edit.js', 'public/js/system/links');

mix.js('resources/assets/js/system/banners/index.js', 'public/js/system/banners');
mix.js('resources/assets/js/system/banners/edit.js', 'public/js/system/banners');

mix.js('resources/assets/js/system/abouts/index.js', 'public/js/system/abouts');
mix.js('resources/assets/js/system/abouts/edit.js', 'public/js/system/abouts');


// 前台 
mix.js('resources/assets/js/app/contact/index.js', 'public/js/app/contact');
mix.js('resources/assets/js/app/news/index.js', 'public/js/app/news');
mix.js('resources/assets/js/app/links/index.js', 'public/js/app/links');
mix.js('resources/assets/js/app/products/index.js', 'public/js/app/products');
