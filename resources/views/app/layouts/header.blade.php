<header id="header" class="header">
    <nav class="nav">
        <div class="header-logo-box">
            <a href="/" class="header-logo">
                <img src="/storage/{{$webConfig->logoB_photoPath}}"
                     alt="{{$webConfig->company_name}}" />
            </a>
            <button type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar"
                    class="navbar-toggle">
                <span class="iconfont icon-hamburger"></span>
            </button>
        </div>

        <ul class="nav-menu">
            <li class="nav-menu-item active">
                <a href="/abouts"
                   @if(Request::is('abouts') || Request::is('abouts/*'))
                   class="active"
                        @endif
                >
                    <span class="nav-title">關於高豐 </span>
                </a>
            </li>

            <li class="nav-menu-item">
                <a href="/news"
                   @if(Request::is('news') || Request::is('news/*'))
                   class="active"
                        @endif
                >
                    <span class="nav-title">最新動態</span>
                </a>
            </li>

            <li class="nav-menu-item">
                <a href="/products"
                   @if(Request::is('products') || Request::is('products/*'))
                   class="active"
                        @endif
                >
                    <span class="nav-title">產品項目</span>
                </a>
                @include('app.layouts.product_category')
            </li>

            <li class="nav-menu-item">
                <a href="/contact"
                   @if(Request::is('contact*'))
                   class="active"
                        @endif
                >
                    <span class="nav-title">聯絡我們</span>
                </a>
            </li>

            {{-- todo: 手機版不見了--}}
            <li class="nav-menu-item">
                <a href="/links"
                   @if(Request::is('links'))
                   class="active"
                        @endif
                >
                    <span class="nav-title">相關連結</span>
                </a>
            </li>

            @if($webConfig->pdfPath <>'')
                <li class="nav-menu-item">
                    <a href="/storage/{{$webConfig->pdfPath}}" download>
                        <span class="nav-title icon-download">電子型錄</span>
                    </a>
                </li>
            @endif
        </ul>

    </nav>
</header>

