<!DOCTYPE html>
<html lang="zh-TW">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="description" content="{{$webConfig->description}}">
<meta name="keywords" content="{{$webConfig->keywords}}">
<title>{{$webConfig->title}}</title>

<!-- Favicons -->
<link rel="apple-touch-icon" href="/asset/images/icon/apple-touch-icon.png">
<link rel="icon" href="/asset/images/icon/favicon.ico">

<!-- css -->
<link rel="stylesheet" type="text/css" href="/asset/style/css/normalize.css">
<link rel="stylesheet" type="text/css" href="/asset/style/css/bootstrap-grid.min.css">
<link rel="stylesheet" type="text/css" href="/asset/style/font/iconfont.css">
<link rel="stylesheet" type="text/css" href="/asset/style/css/tiny-slider.css">
<link rel="stylesheet" type="text/css" href="/asset/style/css/style.css">

<!-- vue使用 -->
<style>
    [v-cloak] {
        display: none;
    }
</style>
<body>

@include('app.layouts.header')

@yield('content')

<!-- footer -->
@include('app.layouts.footer')

<!-- 置頂按鈕 -->
{{--<button class="btn-go-bottom" onclick="goBottom()"><span class="iconfont icon-arrow-down"></span></button>--}}
<button class="btn-go-bottom" onclick="goTop()"><span class="iconfont icon-arrow-down"></span></button>

<script src="/asset/js/header.js" type="text/javascript"></script>
<script src="/asset/js/scrollAnimation.js" type="text/javascript"></script>
<script src="/asset/js/function.js" type="text/javascript"></script>

@yield('pageJS')
</body>
</html>
