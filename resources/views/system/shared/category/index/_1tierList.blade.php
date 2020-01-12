<table width="99%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr>
        <td align="center" bgcolor="#ECECEC" class="border-downright">
            <strong>大分類</strong>
            <a href="/admin/{{$appliedModel}}/categories/create">
                <img src="/system/images/new.gif" width="75" height="19" align="absmiddle"/>
            </a>
        </td>
    </tr>

    {{--main categories--}}
    @foreach($cats->sortBy('ranking') as $cat)
        <tr>
            <td align="left" class="border-downright">
                @include('system.shared.category.index._deleteBtn',['itemId'=>$cat->id])
                @include('system.shared.category.index._rankingInput',['itemId'=>$cat->id,'itemRanking'=>$cat->ranking])
                <a href="/admin/{{$appliedModel}}/categories/{{$cat->id}}/edit">{{$cat->title}}</a>
            </td>
        </tr>
    @endforeach
</table>
