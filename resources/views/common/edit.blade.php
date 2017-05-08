<style>
    form {
        margin: 0;
    }
    textarea {
        display: block;
    }
</style>
<link rel="stylesheet" href="{{url("edit/themes/default/default.css")}}"/>
<script charset="utf-8" src="{{url("edit/kindeditor-min.js")}}"></script>
<script charset="utf-8" src="{{url("edit/lang/zh_CN.js")}}"></script>
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            resizeType : 1,
            allowPreviewEmoticons : true,
            allowImageUpload : false,
            items : [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
            allowFileManager: false,
            width : '800px',
            height: '400px',
            afterBlur: function(){ this.sync(); } //进行同步，解决jquery提交表单的时候接受不到值
        });
        editor.html("");//设置初始值
    });
</script>

<form>
    <textarea id="kindEditorContent" name="content" style="width:700px;height:200px;visibility:hidden;">KindEditor</textarea>
</form>
