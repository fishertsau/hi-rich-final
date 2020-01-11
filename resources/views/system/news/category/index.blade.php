@extends('system.shared.category.index.index',
[
'title'=>'最新消息',
'subTitle' => '消息分類',
'tier3' => (boolean) 0,
'tier2' =>  (boolean) 0,
'cats' => $cats
])

@section('pageJS')
    {{--todo: change for news--}}
    <script type="text/javascript" src="{{ asset('/js/system/category/categoryIndex.js') }}"></script>
@endsection