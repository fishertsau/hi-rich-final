@extends('system.shared.category.create.create',
[
'title'=>'產品管理',
'subTitle' => '產品分類設定',
'appliedModel' => 'product'
])

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/category/categoryCreate.js') }}"></script>
@endsection
