
<? include_view('header') ?>

<div class="header">
    <a href="/" style="float: left;">
        <img src="/application/images/logo.png" style="margin: 9px 0 0 15px;" />
    </a>
    <div style="float: right; margin: 8px 16px 0 0;">
        <a id="saveButton" href="javascript:void(0);" class="saveButton" style="float: left; margin-right: 10px;">Save</a>
        <input id="cancelButton" class="button close" type="button" value="Close" style="float: left;" />
        <div style="float: left; margin: 0 10px; border-left: solid 1px #d0d1d2; border-right: solid 1px #fff; height: 35px;"></div>
        <form id="deleteForm" action="/contextmanager/delete_scenario" method="post" style="float: left;">
            <input type="hidden" name="id" value="<?= $scenario->getId() ?>" />
            <input id="deleteButton" class="button cancel" type="submit" value="Delete" />
        </form>
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

                var scenarioId = '<?= $scenario->getId() ?>';
                var isError = false;
                var errorLine = 0;
                var errorChar = 0;

                var editor = CodeMirror.fromTextArea($('#editor').get(0), {
                    mode: "javascript",
                    lineNumbers: true
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

                $('#deleteForm').submit(function() {
                    if (confirm('Deleting a scenario cannot be undone. Do you wish to continue?')) {
                        return true;
                    }
                    return false;
                });

                $('#cancelButton').click(function() {
                    document.location = '/workbench';
                });

                $('#saveButton').click(function() {

                    if (!$(this).hasClass('active')) {
                        return false;
                    }

                    $(this).text('');
                    $(this).append('<img src="/application/images/button-loader.gif" />');

                    var id = scenarioId;
                    var text = editor.getValue();

                    ContextManager.update_scenario_text({
                        post: {
                            id: id,
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
            <textarea id="editor"><?= $scenario->getText() ?></textarea>
        </div>

    </div>

</div>

<? include_view('footer') ?>