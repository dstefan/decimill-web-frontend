
<? include_view('case_study_header'); ?>

<div id="content">

    <div class="content-left">
        <? include_view('left_menu'); ?>
    </div>

    <div class="content-right">

        <div class="content-block">

            <div class="content-block-header">

                <!-- COMPILE BUTTONS -->
                <div style="float: right;">
                    <a id="showCompiledButton"
                       href="/model/<?= $model->getStudyId() ?>/<?= $model->getId() ?>"
                       class="blink-blue-small">show compiled</a>
                    <a id="compileButton" class="button-grey small disabled" style="margin-top: -2px;">Compile</a>
                </div>

                <!-- MODEL TITLE -->
                <span class="model-title">
                    <i class="fa fa-code-fork" style="margin: 0 7px 0 2px;"></i>
                    <span id="namespace"><?= $model->getNamespace() ?></span>: <span id="title"><?= $model->getTitle() ?></span>
                </span>

                <!-- TITLE EDIT BUTTONS -->
                <a id="editTitleButton" class="blink-blue-small">edit</a>
                <a id="cancelEditTitleButton" class="blink-blue-small" style="display: none;">cancel</a>

            </div>

            <!-- TITLE EDIT FORM -->
            <div id="titleEditForm"
                 style="position: relative; display: none; background-color: #ffffe1; border-bottom: solid 1px #f0f1f2; padding: 10px;">

                <input type="hidden" class="titleFormItem" name="id" value="<?= $model->getId() ?>" />

                <div style="position: absolute; bottom: 10px; right: 10px;">
                    <a id="saveTitleButton" class="button-grey small disabled" style="margin-top: -2px;">Save changes</a>
                </div>

                <table>
                    <tr>
                        <td style="text-align: right; font-weight: bold; padding-right: 5px; color: #444;">Title</td>
                        <td><input type="text" class="titleFormItem" name="title"
                                   style="width: 300px; border: solid 1px #a0a1a2;" value="<?= $model->getTitle() ?>" /></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; font-weight: bold; padding-right: 5px; color: #444;">ID</td>
                        <td><input type="text" class="titleFormItem" name="namespace"
                                   style="width: 100px; border: solid 1px #a0a1a2;" value="<?= $model->getNamespace() ?>" /></td>
                    </tr>
                </table>

            </div>

            <div id="errorOut" style="display: none; background-color: #fee; border-bottom: solid 1px #f0f1f2; padding: 10px; color: red;">
                <code></code>
            </div>

            <input type="hidden" class="compileForm" name="id" value="<?= $model->getId() ?>" />

            <!-- EDITOR TEXTAREA -->
            <textarea id="editor" class="compileForm" name="text"
                      style="box-sizing: border-box; width: 100%; height: 100%; padding: 10px;"><?= $model->getText() ?></textarea>

        </div>

        <div style="background-color: #fff; border: dashed 1px #d7d8d9; border-radius: 4px; margin-top: 25px;">
            <div id="compiled" class="markdown"></div>
        </div>

    </div>

    <script type="text/javascript" src="/application/js/codemirror/addon/hint/show-hint.js"></script>
    <script type="text/javascript" src="/application/js/codemirror/addon/hint/javascript-hint.js"></script>

    <link type="text/css" rel="stylesheet" href="/application/js/codemirror/addon/hint/show-hint.css" />

    <script type="text/javascript">

        var editor = null;
        var isCodeError = false;

        function showError(line, pos, error) {

            // Highlight error position in the editor
            editor.focus();
            editor.addLineClass(line - 1, "background", "error");
            editor.setCursor(line - 1, pos);

            // Change error flag
            isCodeError = true;

            // Show error in the error box
            $('#compileButton').removeClass('disabled');
            $('#errorOut').find('code').text(error);
            $('#errorOut').show();
        }

        function hideError() {

            // Change back error flag
            isCodeError = false;

            // Un-highlight error line in the editor
            $('.error').removeClass('error');

            // Hide error box and change button's label
            $('#showCompiledButton').text('show compiled');
            $('#errorOut').hide();
        }

        function compile() {

            // Update editor's textarea value
            $('#editor').text(editor.getValue());

            // Srialize data
            var data = $('.compileForm').serialize();

            // Disable button
            $('#compileButton').addClass('disabled');

            ModelManager.compile_model({
                post: data,
                success: function (res) {
                    if (res.isError) {
                        var line = res.line;
                        var charPos = res.charPos;
                        var error = res.body
                        showError(line, charPos, error);
                        showCompiled2Cancel();
                    } else {
                        hideError();
                    }
                }
            });
        }

        function saveTitle() {

            var data = $('.titleFormItem').serialize();

            ModelManager.update_model_title({
                post: data,
                success: function (res) {

                    var id = res.id;
                    var title = res.title;
                    var namespace = res.namespace;

                    setTitle(title, namespace);
                    disableSaveTitleButton();
                    hideTitleEditForm();
                    setMenuItemTitle('model', id, title, namespace);
                }
            });
        }

        function disableCompileButton() {
            $('#compileButton').addClass('disabled');
        }

        function enableCompileButton() {
            $('#compileButton').removeClass('disabled');
        }

        function showCompiled2Cancel() {
            $('#showCompiledButton').text('cancel');
        }

        function cancel2ShowCompiled() {
            $('#showCompiledButton').text('show compiled');
        }

        function updateMarkdown() {
            var text = editor.getValue();
            $('#compiled').html(marked(text));
        }

        function setTitle(title, namespace) {
            $('#title').text(title);
            $('#namespace').text(namespace);
        }

        function setMenuItemTitle(type, id, title, namespace) {
            var menuItem = $('.' + type + 'MenuItem[data-' + type + 'id=' + id + ']');
            menuItem.text(namespace + ': ' + title);
        }

        function disableSaveTitleButton() {
            $('#saveTitleButton').addClass('disabled');
        }

        function enableSaveTitleButton() {
            $('#saveTitleButton').removeClass('disabled');
        }

        function hideTitleEditForm() {
            $('#titleEditForm').hide();
            $('#cancelEditTitleButton').hide();
            $('#editTitleButton').show();
        }

        function showTitleEditForm() {
            $('#titleEditForm').show();
            $('#editTitleButton').hide();
            $('#cancelEditTitleButton').show();
        }

        $(function () {

//            CodeMirror.keyMap.basic.Tab = function (cm) {
//                var spaces = Array(cm.getOption("indentUnit") + 3).join(" ");
//                cm.replaceSelection(spaces);
//            };
//
//            CodeMirror.keyMap.basic.Home = "goLineLeft";
//            CodeMirror.keyMap.basic.End = "goLineRight";

            // Initialise editor
            editor = CodeMirror.fromTextArea($('#editor').get(0), {
                mode: 'decimill',
                lineWrapping: true,
                extraKeys: {
                    "Home": "goLineLeft",
                    "End": "goLineRight",
                    "Tab": function (cm) {
                        var spaces = Array(cm.getOption("indentUnit") + 3).join(" ");
                        cm.replaceSelection(spaces);
                    }
                }
            });

            // Add onchange event listener
            editor.on('change', function () {
                enableCompileButton();
                showCompiled2Cancel();
                updateMarkdown();
            });

            // Run init scripts
            compile();
            updateMarkdown();

            $('#editTitleButton').click(function () {
                showTitleEditForm();
            });

            $('#cancelEditTitleButton').click(function () {
                hideTitleEditForm();
            });

            $('.titleFormItem').keyup(function () {
                enableSaveTitleButton();
            });

            $('#saveTitleButton').click(function () {
                saveTitle();
            });

            $('#compileButton').click(function () {
                compile();
            });
        });

    </script>