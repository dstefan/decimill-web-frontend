<!DOCTYPE html>
<html>
    <head>
        <!--<script type="text/javascript" src="/application/js/markdown-js/markdown.js"></script>-->
        <script type="text/javascript" src="/application/js/marked/marked.js"></script>
        <script type="text/javascript" src="/application/js/jquery/jquery.js"></script>
        <script>
            $(function() {
                
                $('#editor').keyup(function() {
                    var raw = $(this).val();
                    $('#preview').html(marked(raw));
                });
            });
        </script>
    </head>
    <body>

        <textarea id="editor"></textarea>

        <div id="preview"></div>

    </body>
</html>