@extends('system.shared.category.index.index',
[
'title'=>'最新動態',
'subTitle' => '動態分類',
'tier3' => (boolean) 0,
'tier2' =>  (boolean) 0,
'cats' => $cats,
'appliedModel' =>  'news'
])

@section('pageJS')
    <script>
      const appliedModel = 'news';
    </script>
    <script type="text/javascript" src="{{ asset('/js/system/category/categoryIndex.js') }}"></script>
@endsection