<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!-- CKEditor init -->
<script src="//cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/adapters/jquery.js"></script>
<script>
    var param = {
        height: 400,
        filebrowserImageUploadUrl: '/ckeditor/upload?type=Images&_token={{csrf_token()}}',
    };

    $("textarea[ckeditor='true']").ckeditor(param);
</script>