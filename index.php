<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tiny.cloud/1/j1r8zopvath74avejol238b9i0zfrgoc117gi6wp7d3g3quw/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <script>
        tinymce.init({
            selector: '#mytextarea',
            language: "ja", // 言語 = 日本語 
            statusbar: false,
            content_css: 'index.css',
            plugins: [
                'print preview fullpage directionality visualblocks visualchars fullscreen image',
                'media template code codesample nonbreaking anchor toc insertdatetime advlist lists textcolor',
                'wordcount imagetools contextmenu colorpicker textpattern help',
            ],
            menubar: 'file edit view',
            toolbar: [
                'undo redo | formatselect | bold italic strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent ',
                'removeformat | image | directionality visualblocks visualchars | codesample code preview fullscreen | template | anchor insertdatetime ',
            ],
            // plugins: 'template image imagetools',
            // toolbar: 'template | image',
            templates: [{
                title: 'Two image template',
                description: 'Two image template',
                url: 'template.html'
            }],
            height: 600,
            // images_upload_url: 'tinymce_upload.php',
            // automatic_uploads: false
            images_upload_handler: function(blobInfo, success, failure) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', 'tinymce_upload.php');
                xhr.onload = function() {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }console.log(xhr.responseText)
                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }
        });
    </script>

</head>

<body>
    <h1>TinyMCE Quick Start Guide</h1>
    <form method="post" id="posts" name="posts">
        <textarea id="mytextarea">Hello, World!</textarea>
    </form>
</body>

</html>