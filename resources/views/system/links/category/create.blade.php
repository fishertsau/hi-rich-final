@extends('system.shared.category.create.create',
[
'title'=>'相關連結',
'subTitle' => '連結分類設定',
'appliedModel' => 'links'
])

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/category/categoryCreate.js') }}"></script>
@endsection
