<!DOCTYPE html>
<html>
    <head>
        <title>CodeMirror tryout</title>
        <meta charset="utf-8"/>

        <script src="/application/js/jquery/jquery.js"></script>
        <script src="/application/js/codemirror/lib/codemirror.js"></script>
        <script src="/application/js/codemirror/mode/javascript/javascript.js"></script>
        <script src="/application/js/codemirror/mode/php/php.js"></script>
        
        <link rel="stylesheet" href="/application/js/codemirror/lib/codemirror.css">
        
        <script>
            $(function() {
                var myCodeMirror = CodeMirror(document.getElementById('editor'), {
                    lineNumbers: true,
                    mode: "php"
                });
            });
        </script>

    </head>
    <body>
        
        <div id="editor" style="width: 800px; height: 500px; border: solid 1px #666; font-size: 20px;"></div>
        
    </body>
</html>