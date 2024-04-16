<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPUB Viewer</title>
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/main.css')}}" />


</head>
<body>
<div id="main">
    <div id="titlebar">
        <div id="metainfo">
            <span id="book-title"></span>
            <span id="title-seperator">&nbsp;&nbsp;–&nbsp;&nbsp;</span>
            <span id="chapter-title"></span>
        </div>
    </div>
    <div id="divider"></div>
    <div id="prev" class="arrow">‹</div>
    <div id="viewer"></div>
    <div id="next" class="arrow">›</div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
<script src="{{asset('front-assets/js/epub.js')}}"></script>
<script src="{{asset('front-assets/js/reader.js')}}"></script>

<script type="text/javascript">
    window.onload = function () {
        ePubReader("{{ $fileUrl }}");
    };
</script>


</body>
</html>
