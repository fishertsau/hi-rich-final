<footer>
    <div class="footer-content">
        <div class="footer-link-box">
            <a href="/abouts" class="link-item">關於高豐</a>
            <a href="/news" class="link-item">最新動態</a>
            <a href="/products" class="link-item">產品項目</a>
            <a href="/contact" class="link-item">聯絡我們</a>
            <a href="/links" class="link-item">相關連結</a>
        </div>
        <hr />
        <div class="footer-info">
            <a href="/" class="logo">
                <img src="/storage/{{$webConfig->logoA_photoPath}}" alt="{{$webConfig->company_name}}">
            </a>
            <div class="footer-info-content">
                <span class="text-address">{{$webConfig->address}}</span>
                <span class="text-phone">TEL:{{$webConfig->tel}}</span>
                <span class="text-phone">FAX:{{$webConfig->fax}}</span>
            </div>
        </div>
    </div>
    <div class="copyright">
        {{$webConfig->copyright_declare}} | All Rights Reserved. 版權所有 <span>網頁設計 by 異果設計</span>
    </div>
</footer>

