@extends('system.shared.category.create.create',
[
'title'=>'最新消息',
'subTitle' => '消息分類設定',
'appliedModel' => 'news'
])

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/category/categoryCreate.js') }}"></script>
@endsection
