{{-- todo: change url link --}}
<header id="header" class="header">
    <nav class="nav">
        <div class="header-logo-box">
            <a href="/" class="header-logo">
                <img src="/asset/images/logo-white.png" alt="高豐海產股份有限公司">
            </a>
            <button type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"
                    class="navbar-toggle">
                <span class="iconfont icon-hamburger"></span>
            </button>
        </div>

        {{-- todo: change link --}}
        <ul class="nav-menu">
            <li class="nav-menu-item">
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
                
                {{-- todo: get the category from backend --}}
                <ul class="nav-submenu">
                    <li class="nav-submenu-item">
                        <a href="javascript:;">蝦類</a>
                        <ul class="nav-tirmenu">
                            <li class="nav-tirmenu-item"> <a href="javascript:;">白蝦</a></li>
                            <li class="nav-tirmenu-item"> <a href="javascript:;">草蝦</a></li>
                            <li class="nav-tirmenu-item"> <a href="javascript:;">泰國蝦</a></li>
                        </ul>
                    </li>
                    <li class="nav-submenu-item">
                        <a href="javascript:;">貝類</a>
                        <ul class="nav-tirmenu">
                            <li class="nav-tirmenu-item"> <a href="javascript:;">扇貝</a></li>
                            <li class="nav-tirmenu-item"> <a href="javascript:;">奶油貝</a></li>
                            <li class="nav-tirmenu-item"> <a href="javascript:;">貝貝</a></li>
                        </ul>
                    </li>
                    <li class="nav-submenu-item">
                        <a href="javascript:;">魚類</a>
                        <ul class="nav-tirmenu">
                            <li class="nav-tirmenu-item"> <a href="javascript:;">白帶魚</a></li>
                            <li class="nav-tirmenu-item"> <a href="javascript:;">黃魚</a></li>
                            <li class="nav-tirmenu-item"> <a href="javascript:;">燈籠魚</a></li>
                        </ul>
                    </li>
                    <li class="nav-submenu-item">
                        <a href="javascript:;">軟體類</a>
                        <ul class="nav-tirmenu">
                            <li class="nav-tirmenu-item"> <a href="javascript:;">軟絲</a></li>
                            <li class="nav-tirmenu-item"> <a href="javascript:;">魷魚</a></li>
                            <li class="nav-tirmenu-item"> <a href="javascript:;">海帶</a></li>
                        </ul>
                    </li>
                    <li class="nav-submenu-item">
                        <a href="javascript:;">甲殼類</a>
                        <ul class="nav-tirmenu">
                            <li class="nav-tirmenu-item"> <a href="javascript:;">牡蠣</a></li>
                            <li class="nav-tirmenu-item"> <a href="javascript:;">蚵仔</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-menu-item">
                <a href="/contact">
                    <span class="nav-title">聯絡我們</span>
                </a>
            </li>
            <li class="nav-menu-item">
                <a href="/links">
                    <span class="nav-title">相關連結</span>
                </a>
            </li>
            {{-- todo: implement this--}}
            <li class="nav-menu-item">
                <a href="javascript:;">
                    <span class="nav-title icon-download">電子型錄</span>
                </a>
            </li>
        </ul>
    </nav>
</header>

