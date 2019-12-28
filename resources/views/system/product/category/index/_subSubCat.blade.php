@include('system.product.category.index._deleteBtn',['itemId'=>$subSubCat->id])
@include('system.product.category.index._rankingInput',['itemId'=>$subSubCat->id,'itemRanking'=>$subSubCat->ranking])
<a href="/admin/product/categories/{{$subSubCat->id}}/edit">{{$subSubCat->title}}
    @if(config('app.english_enabled'))
        | {{$subSubCat->title_en}}
    @endif
</a>
<br>