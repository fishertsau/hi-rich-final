<div id="leftmenu">
    <ul id="nav">
        <li>
            <a href="/admin/banner">首頁跑馬燈</a>
        </li>

        {{--公司簡介管理--}}
        <li><a href="/admin/abouts">公司簡介</a></li>

        {{--產品管理--}}
        <li><a href="#Menu=ChildMenu1" onclick="DoMenu('ChildMenu1')">產品管理 <img src="/system/images/arrow-down.png"
                                                                                width="11" height="6" /></a>
            <ul id="ChildMenu1" class="collapsed">

                <li><a href="/admin/product/categories"><img src="/system/images/arrow.png" width="10" height="10" />
                        產品分類管理</a></li>
                <li><a href="/admin/products"><img src="/system/images/arrow.png" width="10" height="10" /> 產品上架管理</a>
                <li><a href="/admin/products/config"><img src="/system/images/arrow.png" width="10" height="10" />
                        前台筆數顯示設定</a></li>
                </li>
            </ul>
        </li>

        {{--據點清單--}}
        <li>
            <a href="/admin/sites">據點清單</a>
        </li>

        {{--最新消息--}}
        <li>
            <a href="#Menu=ChildMenu2"
               onclick="DoMenu('ChildMenu2')">最新消息 <img src="/system/images/arrow-down.png"></a>
            <ul id="ChildMenu2" class="collapsed">
                <li>
                    <a href="/admin/news/categories">
                        <img src="/system/images/arrow.png" width="10" height="10" />
                        消息分類設定
                    </a>
                </li>
                <li><a href="/admin/news"><img src="/system/images/arrow.png" width="10" height="10" /> 消息清單</a>
                {{--todo: 視情況將此項做設定--}}
                <li><a href="/admin/news/config"><img src="/system/images/arrow.png" width="10" height="10" />
                        前台筆數顯示設定</a></li>
                </li>
            </ul>
        </li>

        <li>
            <a href="/admin/links">相關連結</a>
        </li>

        <li><a href="#Menu=ChildMenu3"
               onclick="DoMenu('ChildMenu3')">聯絡表單<img
                        src="/system/images/arrow-down.png" width="11" height="6" /></a>
            <ul id="ChildMenu3" class="collapsed">
                <li><a href="/admin/contacts"><img src="/system/images/arrow.png" width="10" height="10" />聯絡信件管理</a>
                </li>
                <li><a href="/admin/contacts/template"><img src="/system/images/arrow.png" width="10" height="10" />
                        內容和送出頁管理</a></li>
            </ul>
        </li>

        {{--設定管理--}}
        <li><a href="#Menu=ChildMenu4" onclick="DoMenu('ChildMenu4')">各項設定<img src="/system/images/arrow-down.png">
                <ul id="ChildMenu4" class="collapsed">
                    <li><a href="/admin/settings/siteFooter">
                            <img src="/system/images/arrow.png" width="10" height="10" />
                            網站內容</a>
                    </li>
                    <li><a href="/admin/settings/pageInfo"><img src="/system/images/arrow.png" width="10" height="10" />
                            網站設定</a>
                    </li>
                    <li><a href="/admin/settings/googleMap"><img src="/system/images/arrow.png" width="10"
                                                                 height="10" />
                            Google地圖與地址設定</a>
                    </li>
                    <li><a href="/admin/settings/mailService"><img src="/system/images/arrow.png" width="10"
                                                                   height="10" />
                            信件設定</a></li>
                    <li><a href="/admin/settings/password"><img src="/system/images/arrow.png" width="10" height="10" />
                            修改密碼</a>
                    </li>
                </ul>
            </a>
        </li>
    </ul>
</div>
<script type=text/javascript><!--
  var LastLeftID = "";

  function menuFix() {
    var obj = document.getElementById("nav").getElementsByTagName("li");

    for(var i = 0; i < obj.length; i++) {
      obj[i].onmouseover = function () {
        this.className += (this.className.length > 0 ? " " : "") + "sfhover";
      }
      obj[i].onMouseDown = function () {
        this.className += (this.className.length > 0 ? " " : "") + "sfhover";
      }
      obj[i].onMouseUp = function () {
        this.className += (this.className.length > 0 ? " " : "") + "sfhover";
      }
      obj[i].onmouseout = function () {
        this.className = this.className.replace(new RegExp("( ?|^)sfhover\\b"), "");
      }
    }
  }

  function DoMenu(emid) {
    var obj = document.getElementById(emid);
    obj.className = (obj.className.toLowerCase() == "expanded" ? "collapsed" : "expanded");
    if ((LastLeftID != "") && (emid != LastLeftID)) //Menu
    {
      document.getElementById(LastLeftID).className = "collapsed";
    }
    LastLeftID = emid;
  }

  function GetMenuID() {
    var MenuID = "";
    var _paramStr = new String(window.location.href);
    var _sharpPos = _paramStr.indexOf("#");

    if (_sharpPos >= 0 && _sharpPos < _paramStr.length - 1) {
      _paramStr = _paramStr.substring(_sharpPos + 1, _paramStr.length);
    } else {
      _paramStr = "";
    }

    if (_paramStr.length > 0) {
      var _paramArr = _paramStr.split("&");
      if (_paramArr.length > 0) {
        var _paramKeyVal = _paramArr[0].split("=");
        if (_paramKeyVal.length > 0) {
          MenuID = _paramKeyVal[1];
        }
      }
        /*
         if (_paramArr.length>0)
         {
         var _arr = new Array(_paramArr.length);
         }

         //Menu
         //for (var i = 0; i < _paramArr.length; i++)
         {
         var _paramKeyVal = _paramArr[i].split('=');

         if (_paramKeyVal.length>0)
         {
         _arr[_paramKeyVal[0]] = _paramKeyVal[1];
         }
         }
         */
    }

    if (MenuID != "") {
      DoMenu(MenuID)
    }
  }

  GetMenuID(); //*functionFirefoxGetMenuID()
  menuFix();
  --></script>