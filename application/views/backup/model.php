<?= include_view('header'); ?>

<link rel="stylesheet" href="/application/js/codemirror/lib/codemirror.css">

<style>
    table.parameters { border-collapse: collapse; }
    table.parameters td { padding: 0; }
    table.parameters td.label { padding-right: 10px; text-align: right; }
    table.parameters input { padding: 3px; margin: 0 0 -1px 0; border: solid 1px #e1e2e3; }
</style>

<script src="/application/js/jquery/ajax.js"></script>
<script src="/application/js/controllers/ModelManager.js"></script>
<script src="/application/js/codemirror/lib/codemirror.js"></script>

<script>
    $(function() {

        var editor = CodeMirror.fromTextArea($('#editor').get(0), {
            lineNumbers: true,
            lineWrapping: true
        });

        editor.on('change', function() {
            $('#saveChangesButton').removeClass('disabled');
//            if (isError) {
//                editor.removeLineClass(errorLine, 'background', 'lineError');
//                isError = false;
//            }
        });

        $('#saveChangesButton').click(function() {
            $('#editor').val(editor.getValue());
            var data = $('.modelForm').serialize();
            ModelManager.update_model({
                post: data,
                success: function(res) {
                    if (!res.isError) {
                        var paramList = $('#paramList');
                        paramList.html('');
                        var vars = res.body.unassignedVarNames;
                        var params = res.body.params;
                        for (var i = 0; i < vars.length; i++) {
                            var varName = vars[i];
                            var value = params[varName];
                            value = value === undefined ? '' : value;
                            paramList.append('<tr><td class="label">' + varName + '</td><td><input name="param[' + varName + ']" class="paramsForm" type="text" value="' + value + '" /></td></tr>');
                        }
                        $('#saveChangesButton').addClass('disabled');
                    }
                    //console.log(res);
                }
            });
        });

        $('#saveParamsButton').click(function() {
            var data = $('.paramsForm').serialize();
            ModelManager.update_params({
                post: data,
                success: function(res) {
                    console.log(res);
                }
            });
        });
    });
</script>

<?= include_view('heading'); ?>

<input type="hidden" class="modelForm paramsForm" name="modelId" value="<?= $model->getId() ?>" />

<div class="content-box content-box-outline" style="border-radius: 0 0 4px 4px; margin-top: -1px;">
    <div class="content-box-wrapper">
        <table>
            <tr>
                <td style="text-align: right; font-family: 'Open Sans', sans-serif; font-size: 25px;">Model</td>
                <td><input type="text" class="modelForm" name="title" value="<?= $model->getTitle() ?>" style="border: none; background-color: #ffc; padding: 10px 10px 7px 10px; font-size: 25px; color: #333; width: 500px;" /></td>
            </tr>
            <tr>
                <td style="font-family: 'Open Sans', sans-serif; font-size: 16px;">Namespace</td>
                <td><input type="text" class="modelForm" name="namespace" value="<?= $model->getNamespace() ?>" style="border: none; background-color: #ffc; padding: 10px 10px 7px 10px; font-size: 16px; color: #333;" /></td>
            </tr>
        </table>
    </div>
</div>

<!-- EDITOR -->
<div>
    <div class="content-box-label">
        <div class="content-box-label-wrapper">
            Model editor
        </div>
    </div>
    <div class="content-box content-box-outline">
        <textarea id="editor" class="modelForm" name="text"><?= $model->getText() ?></textarea>
        <div class="content-box-footer">
            <div class="content-box-footer-buttons">
                <input id="saveChangesButton" type="button" class="button-grey disabled" value="Save changes" />
            </div>
        </div>
    </div>
</div>

<!-- PARAMETERS -->
<div>
    <div style="font-family: 'Roboto Condensed'; font-weight: 300; font-size: 25px; width: 800px; margin: 20px auto 5px;">
        <span style="margin-left: 10px;">Parameters</span>
    </div>
    <div style="width: 800px; background-color: #fff; margin: 0 auto 20px; border-radius: 4px; border: solid 1px #e7e8e9; border-bottom-width: 2px;">
        <div style="padding: 32px 30px;">
            <table id="paramList" class="parameters">
                <? foreach ((array) @$info->unassignedVarNames AS $varName): ?>
                    <tr>
                        <td class="label"><?= $varName ?></td>
                        <td><input class="paramsForm" type="text" name="param[<?= $varName ?>]" value="<?= @$params[$varName] ?>" /></td>
                    </tr>
                <? endforeach ?>
            </table>
        </div>
        <div class="content-box-footer">
            <div class="content-box-footer-buttons">
                <input id="saveParamsButton" type="button" class="button-grey" value="Save parameters" />
            </div>
        </div>
    </div>
</div>

<!-- COMMENTS -->
<div>
    <div class="content-box-label">
        <div class="content-box-label-wrapper">
            Comments
        </div>
    </div>
    <div class="content-box content-box-outline">
        <div class="content-box-wrapper">
            Comments...
        </div>
    </div>
</div>

<?= include_view('footer'); ?>