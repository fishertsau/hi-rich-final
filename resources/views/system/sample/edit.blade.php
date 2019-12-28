@extends('system.layouts.master')

@section('content')
    <!-- include libraries(bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>安裝實例管理&gt;
            @if(isset($copySample))
                複製實例
            @elseif(isset($sample))
                修改實例
            @else
                新增實例
            @endif
        </div>

        @if(!isset($sample) | isset($copySample))
            <form action="/admin/samples" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('system.sample._form')
            </form>
        @endif


        @if(isset($sample) && !isset($copySample))
            <form action="/admin/samples/{{$sample->id}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                @include('system.sample._form')
            </form>
        @endif

        <br/>
    </div>
@endsection


@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/sample/sampleEdit.js') }}"></script>

    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    <script src="{{ asset('vendors/summernote/lang/summernote-zh-TW.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $('.textarea').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['fontsize', ['fontsize']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture', 'link', 'video']],
                    ['table', ['table']],
                    ['misc', ['codeview', 'fullscreen']]
                ],
                height: 1500,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                lang: 'zh-TW',
                callbacks: {
                    onImageUpload: function (image) {
                        uploadImage(image[0]);
                    }
                }
            });
        });


        function uploadImage(image) {
            console.log('hello upload image');
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                data: data,
                type: "POST",
                url: "/test",// this file uploads the picture and
                                 // returns a chain containing the path
                cache: false,
                contentType: false,
                processData: false,
                success: function (url) {
                    let IMAGE_PATH = '/storage/';
                    console.log(url);
                    var image = IMAGE_PATH + url;
                    console.log(image);
                    $('#summernote').summernote("insertImage", image);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
