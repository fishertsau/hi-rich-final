let mix = require('laravel-mix');

mix.js('resources/assets/js/system/category/categoryIndex.js', 'public/js/system/category');
mix.js('resources/assets/js/system/category/categoryCreate.js', 'public/js/system/category');

mix.js('resources/assets/js/system/product/productCreate.js', 'public/js/system/product');
mix.js('resources/assets/js/system/product/productIndex.js', 'public/js/system/product');

mix.js('resources/assets/js/system/service/serviceCreate.js', 'public/js/system/service');
mix.js('resources/assets/js/system/service/serviceIndex.js', 'public/js/system/service');


mix.js('resources/assets/js/system/sample/sampleEdit.js', 'public/js/system/sample');
mix.js('resources/assets/js/system/sample/sampleIndex.js', 'public/js/system/sample');

mix.js('resources/assets/js/system/inquiry/inquiryShow.js', 'public/js/system/inquiry');
mix.js('resources/assets/js/system/contact/contactShow.js', 'public/js/system/contact');

mix.js('resources/assets/js/system/news/newsIndex.js', 'public/js/system/news');

mix.js('resources/assets/js/system/banner/banner.js', 'public/js/system/banner');
mix.js('resources/assets/js/system/about/about.js', 'public/js/system/about');