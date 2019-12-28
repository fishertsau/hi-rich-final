<h5>您好,有人送出詢問</h5>

<p>相關訊息如下:</p>
<div>
    <ul>
        <li>詢問:{{$inquiry->subject}}</li>
        @if(isset($inquiry->product))
            <li>產品:{{$inquiry->product}}</li>
        @endif
        <li>姓名:{{$inquiry->name}}</li>
        <li>Email:{{$inquiry->email}}</li>
        <li>電話:{{$inquiry->tel}}</li>
        <li>傳真:{{$inquiry->fax}}</li>
        <li>內容:{{$inquiry->message}}</li>
    </ul>
</div>