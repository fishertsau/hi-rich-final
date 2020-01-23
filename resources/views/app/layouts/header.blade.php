<header id="header" class="header">
    <nav class="nav">
        <div class="header-logo-box">
            <a href="/" class="header-logo">
                <img src="/asset/images/logo-white.png" alt="高豐海產股份有限公司">
            </a>
            <button type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar"
                    class="navbar-toggle">
                <span class="iconfont icon-hamburger"></span>
            </button>
        </div>

        {{-- todo: add 'active' --}}
        <ul class="nav-menu">
            <li class="nav-menu-item">
                {{--todo: implement this--}}
                <!-- acitve 在當下對應的頁面時需加上此class -->
                <a href="/abouts">
                    <span class="nav-title">關於高豐</span>
                </a>
            </li>
            <li class="nav-menu-item">
                <a href="/news">
                    <span class="nav-title">最新動態</span>
                </a>
            </li>
            <li class="nav-menu-item">
                <a href="/products">
                    <span class="nav-title">產品項目</span>
                </a>
                @include('app.layouts.product_category')
            </li>
            <li class="nav-menu-item">
                <a href="/contact">
                    <span class="nav-title">聯絡我們</span>
                </a>
            </li>
            <li class="nav-menu-item active">
                <a href="/links">
                    <span class="nav-title">相關連結</span>
                </a>
            </li>
            <li class="nav-menu-item">
                <a href="/storage/{{$webConfig->pdfPath}}" download >
                    <span class="nav-title icon-download">電子型錄</span>
                </a>
            </li>
        </ul>
    </nav>
</header>

