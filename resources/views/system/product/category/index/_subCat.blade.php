@include('system.product.category.index._deleteBtn',['itemId'=>$subCat->id])
@include('system.product.category.index._rankingInput',['itemId'=>$subCat->id,'itemRanking'=>$subCat->ranking])
<a href="/admin/product/categories/{{$subCat->id}}/edit">{{$subCat->title}}
    @if(config('app.english_enabled'))
        | {{$subCat->title_en}}
    @endif
</a>　
@if(isset($subCat->parentCategory))
    <a href="/admin/product/categories/create?parentId={{$subCat->id}}">
        <img
                src="/system/images/new.gif"
                width="75"
                height="19"
                align="absmiddle"/>
    </a>
@endif