{{-- todo: change or delete this file --}}

<ul class="dropdown-menu">
    @foreach($publishedProducts as $product)
        <li><a href="/products/{{$product->id}}">{{$lP->localeField($product,'title')}}</a></li>
    @endforeach
</ul>
