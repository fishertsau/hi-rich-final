<h5>您好,有人送出詢問</h5>

<p>相關訊息如下:</p>
<div>
    <ul>
        @if(isset($contact->product))
            <li>產品:{{$contact->product}}</li>
        @endif
        <li>主旨:{{$contact->title}}</li>
        <li>姓名:{{$contact->contact}}</li>
        <li>Email:{{$contact->email}}</li>
        <li>電話:{{$contact->tel}}</li>
        <li>傳真:{{$contact->fax}}</li>
        <li>內容:{{$contact->message}}</li>
    </ul>
</div>