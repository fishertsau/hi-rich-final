@extends('app.layouts.master')

@section('content')
    <div class="page-bg">
        <section class="product-box">
            <div class="container">
                <div class="row">
                    @include('app.products.categorySidebar')
                    <div class="col-md-9 col-sm-8 col-12">
                        <div class="section-title">全部產品</div>
                        <div class="links-list set-height">
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                        <a href="/products/{{$product->id}}" class="links-item">
                                            <img src="/storage/{{$product->photoPath}}">
                                            <span class="text-links-name">{{$product->title}}</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{$products->links('vendor.pagination.app')}}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
