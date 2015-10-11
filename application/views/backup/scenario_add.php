
<? include_view('header') ?>

<div class="header">
    <a href="/" style="float: left;">
        <img src="/application/images/logo.png" style="margin: 9px 0 0 15px;" />
    </a>
    <div style="float: right; margin: 8px 16px 0 0;">
        <a id="saveButton" href="javascript:void(0);" class="saveButton" style="float: left; margin-right: 10px;">Save</a>
        <input id="cancelButton" class="button close" type="button" value="Close" style="float: left;" />
    </div>
</div>

<style>
    .lineError { background-color: #fcc; }
</style>

<div class="main">

    <? include_view('leftColumn') ?>

    <div class="rightColumn">

        <script type="text/javascript">

            $(function() {

                var isError = false;
                var errorLine = 0;
                var errorChar = 0;

                var editor = CodeMirror.fromTextArea($('#editor').get(0), {
                    mode: "javascript",
                    lineNumbers: true
                });

                $('#cancelButton').click(function() {
                    document.location = '/workbench';
                });

                editor.on('change', function() {

                    if (!$('#saveButton').hasClass('active')) {
                        $('#saveButton').addClass('active');
                    }

                    if (isError) {
                        editor.removeLineClass(errorLine, 'background', 'lineError');
                        isError = false;
                    }
                });

                $('#saveButton').click(function() {

                    if (!$(this).hasClass('active')) {
                        return false;
                    }

                    $(this).text('');
                    $(this).append('<img src="/application/images/button-loader.gif" />');

                    var text = editor.getValue();

                    ContextManager.add_scenario({
                        post: {
                            text: text
                        },
                        success: function(res) {
                            if (res.isError) {
                                errorLine = res.body.line - 1;
                                errorChar = res.body.charPos;
                                editor.addLineClass(errorLine, 'background', 'lineError');
                                editor.focus();
                                editor.setCursor({line: errorLine, ch: errorChar});
                                isError = true;
                                $('#saveButton').html('Save');
                            } else {
                                window.location = '/scenario/' + res.body.id;
                            }
                        }
                    });
                });
            });

        </script>

        <div class="editorWrapper">
            <textarea id="editor">Scenario: Scenario Name (ID)

// Changes
Change: ModID.var1 = ModID.var1 + 1000
Change: ModID.var2 = ModID.var2 - 100</textarea>
        </div>

    </div>

</div>

<? include_view('footer') ?>