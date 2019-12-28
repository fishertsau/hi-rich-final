{{--todo: change or delete this file --}}
<ul class="dropdown-menu">
    <?php
    $uri = $webConfig->category_photo_enabled ? "/categories/" : "/products/category/"
    ?>

    @foreach($categories as $category)
        <li class="{{$catPst->childCatForView($category)->count()>0?'dropdown':''}}">
            <a href="{{$uri}}{{$category->id}}" class="dropdown-toggle"  onclick="location.href=$(this).attr('href')">
                {{$lP->localeField($category,'title')}}
            </a>
            @if($catPst->childCatForView($category)->count()>0)
                <ul class="dropdown-menu">
                    @foreach($catPst->childCatForView($category) as $subCategory)
                        <li class="{{$catPst->childCatForView($subCategory)->count()>0?'dropdown':''}}">
                            <a href="{{$uri}}{{$subCategory->id}}"
                               class="dropdown-toggle">{{$lP->localeField($subCategory,'title')}}</a>
                            @if($catPst->childCatForView($subCategory)->count()>0)
                                <ul class="dropdown-menu">
                                    @foreach($catPst->childCatForView($subCategory) as $subSubCategory)
                                        <li>
                                            <a href="{{$uri}}{{$subSubCategory->id}}">{{$lP->localeField($subSubCategory,'title')}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
