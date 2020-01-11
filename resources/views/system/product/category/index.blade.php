@extends('system.shared.category.index.index',
[
'title'=>'產品管理',
'subTitle' => '產品分類',
'tier3' => config('app.product_category_tier3_enabled') ,
'tier2' =>  config('app.product_category_tier2_enabled'),
'cats' => $cats
])

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/category/categoryIndex.js') }}"></script>
@endsection