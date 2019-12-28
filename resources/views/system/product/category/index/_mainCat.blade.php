@include('system.product.category.index._deleteBtn',['itemId'=>$cat->id])
@include('system.product.category.index._rankingInput',['itemId'=>$cat->id,'itemRanking'=>$cat->ranking])

<a href="/admin/product/categories/{{$cat->id}}/edit">
    {{$cat->title}}

    @if(config('app.english_enabled'))
        | {{$cat->title_en}}
    @endif
</a>

<a href="/admin/product/categories/create?parentId={{$cat->id}}">
    <img
            src="/system/images/new.gif"
            width="75" height="19"
            align="absmiddle"/>
</a>
