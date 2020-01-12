@extends('system.shared.category.index.index',
[
'title'=>'相關連結',
'subTitle' => '連結分類',
'tier3' => (boolean) 0,
'tier2' =>  (boolean) 0,
'cats' => $cats,
'appliedModel' =>  'links'
])

@section('pageJS')
    <script>
      const appliedModel = 'links';
    </script>
    <script type="text/javascript" src="{{ asset('/js/system/category/categoryIndex.js') }}"></script>
@endsection