<table width="99%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr>
        <td align="center" bgcolor="#ECECEC" class="border-downright">
            <strong>大分類</strong>
            <a href="/admin/product/categories/create">
                <img src="/system/images/new.gif" width="75" height="19" align="absmiddle"/>
            </a>
        </td>
        <td align="center" bgcolor="#ECECEC" class="border-downright"><strong>次分類</strong></td>
        <td align="center" bgcolor="#ECECEC" class="border-down"><strong>次次分類</strong></td>
    </tr>

    {{--main categories--}}
    @foreach($cats->sortBy('ranking') as $cat)
        @if(count($cat->childCategories)===0)
            <tr>
                <td align="left" class="border-downright">
                    @include('system.shared.category.index._mainCat')
                </td>
                <td align="left" class="border-downright"></td>
                <td align="left" class="border-downright"></td>
            </tr>
        @endif

        @if(count($cat->childCategories)===1)
            <tr>
                <td align="left" class="border-downright">
                    @include('system.shared.category.index._mainCat')
                </td>
                @foreach($cat->childCategories->sortBy('ranking') as $subCat)
                    <td align="left" class="border-downright">
                        @include('system.shared.category.index._subCat')
                    </td>
                    <td align="left" class="border-downright">
                        @foreach($subCat->childCategories->sortBy('ranking') as $subSubCat)
                            @include('system.shared.category.index._subSubCat')
                        @endforeach
                    </td>
                @endforeach
            </tr>
        @endif

        @if(count($cat->childCategories)>1)
            <tr>
                <td align="left" class="border-downright" rowspan="{{count($cat->childCategories)+1}}">
                    @include('system.shared.category.index._mainCat')
                </td>
            </tr>
            @foreach($cat->childCategories->sortBy('ranking') as $subCat)
                <tr>
                    <td align="left" class="border-downright">
                        @include('system.shared.category.index._subCat')
                    </td>
                    <td align="left" class="border-downright">
                        @foreach($subCat->childCategories->sortBy('ranking') as $subSubCat)
                            @include('system.shared.category.index._subSubCat')
                        @endforeach
                    </td>
                </tr>
            @endforeach
        @endif
    @endforeach

    {{--sub Category without parent--}}
    @if(count($nullParentSubCategories)>0)
        @foreach($nullParentSubCategories as $subCat)
            <tr>
                <td align="center" class="border-downright"><p style="color:red">無大分類</p></td>
                <td align="left" class="border-downright">
                    @include('system.shared.category.index._subCat')
                </td>
                <td align="left" class="border-downright">
                    @foreach($subCat->childCategories as $subSubCat)
                        @include('system.shared.category.index._subSubCat')
                    @endforeach
                </td>
            </tr>
        @endforeach
    @endif

    {{--sub sub categories without parent--}}
    @if(count($nullParentSubSubCategories)>0)
        @foreach($nullParentSubSubCategories as $subSubCat)
            <tr>
                <td align="center" class="border-downright">
                    <p style="color:red">無大分類</p>
                </td>
                <td align="center" class="border-downright">
                    <p style="color:red">無次分類</p>
                </td>
                <td align="left" class="border-downright">
                    @include('system.shared.category.index._subSubCat')
                </td>
            </tr>
        @endforeach
    @endif
</table>
