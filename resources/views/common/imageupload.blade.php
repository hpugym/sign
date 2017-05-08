<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>图片上传</title>
    <!-- add styles -->
    <link href="{{asset("upload/css/main.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("upload/css/jquery.Jcrop.min.css")}}" rel="stylesheet" type="text/css" />

    <!-- add scripts -->
    <script src="{{asset("upload/js/jquery.min.js")}}"></script>
    <script src="{{asset("upload/js/jquery.Jcrop.min.js")}}"></script>
    <script src="{{asset("upload/js/script.js")}}"></script>
</head>
<body>
<div class="demo" style=" margin-top:60px;">
    <div class="bbody">

        <!-- upload form -->
        <form id="upload_form" enctype="multipart/form-data" method="post" action="{{url("image-uploading")}}" onsubmit="return checkForm()">
        {{csrf_field()}}
        <!-- hidden crop params -->
            <input type="hidden" id="x1" name="x1" />
            <input type="hidden" id="y1" name="y1" />
            <input type="hidden" id="x2" name="x2" />
            <input type="hidden" id="y2" name="y2" />

            <h2>第一步:请选择图像文件</h2>
            <div><input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" /></div>
            <div class="error"></div>
            <div class="step2">
                <h2>请选择需要截图的部位,然后按上传</h2>
                <img id="preview" />
                <div class="info">
                    <label>文件大小</label> <input type="text" id="filesize" name="filesize" />
                    <label>类型</label> <input type="text" id="filetype" name="filetype" />
                    <label>图像尺寸</label> <input type="text" id="filedim" name="filedim" />
                    <label>宽度</label> <input type="text" id="w" name="w" />
                    <label>高度</label> <input type="text" id="h" name="h" />
                </div>

                <input type="submit" value="上传" />
            </div>
        </form>
    </div>
</div>
</body>
</html>