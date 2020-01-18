<ul class="nav-submenu">
    @foreach($categories as $category)
        <li class="nav-submenu-item">
            <a href="/products/category/{{$category->id}}">{{$category->title}}</a>
            @if($category->childCategories->count()>0)
                <ul class="nav-tirmenu">
                    @foreach($category->childCategories as $subCat)
                        <li class="nav-tirmenu-item"><a href="/products/category/{{$subCat->id}}">{{$subCat->title}}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
