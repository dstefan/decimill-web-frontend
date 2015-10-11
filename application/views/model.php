
<? include_view('case_study_header'); ?>

<div id="content">

    <div class="content-left">
        <? include_view('left_menu'); ?>
    </div>

    <div id="goalBlock" style="display: none; padding: 10px; background-color: #fff; position: absolute; border-radius: 3px; border: solid 1px #f0f1f2; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
        <img id="goalPic" src="" />
    </div>

    <div class="content-right">

        <div class="content-block">

            <div class="content-block-header">
                <div style="float: right;">
                    <a class="blink-red-small" id="deleteButton" data-studyid="<?= $study->getId() ?>" data-modelid="<?= $model->getId() ?>">delete</a>
                    <a class="blink-blue-small" href="/model/<?= $model->getStudyId() ?>/<?= $model->getId() ?>/edit" style="">edit</a>
                </div>
                <span class="model-title">
                    <i class="fa fa-code-fork" style="margin: 0 7px 0 2px;"></i>
                    <span id="modelNamespace"><?= $model->getNamespace() ?></span>: <span id="modelTitle"><?= $model->getTitle() ?></span>
                </span>
            </div>

            <? $text = $parser->text($model->getCompiled()) ?>

            <div class="markdown" style="padding: 15px 20px;">
                <? if (file_exists(APPPATH . 'images/models/' . $model->getId() . '/full.png')): ?>
                    <?= preg_replace("/(<h1.*<\/h1>)/", '$1<div><div id="model" style="padding: 30px 15px 30px; text-align: center;"><img id="modelPreview" src="/application/images/models/' . $model->getId() . '/full.png?' . time() . '" style="max-width: 100%;" data-title="' . $model->getTitle() . '"/></div></div>', $text); ?>
                <? else: ?>
                    <?= $text ?>
                <? endif; ?>
            </div>

        </div>

    </div>

    <style>
        .model-view { display: none; z-index: 999; position: fixed; width: 100%; height: 100%; top: 0; left: 0; background-color: red; }
        .model-node { cursor: default; }
        #modelPreview { cursor: pointer; cursor: hand; }
    </style>

    <div class="model-view">
        <img id="modelCanvas" src="/application/images/models/1/full.png" />
    </div>

    <script>
        $(function () {

            var timeout = null;

            $('.model-node').hover(function (e) {

                var modelId = $(this).data('modelid');
                var nodeId = $(this).data('nodeid');

                timeout = setTimeout(function () {
                    $('#goalPic').attr('src', '/application/images/models/' + modelId + '/' + nodeId + '.png');
                    $('#goalPic').load(function () {
                        var width = $('#goalBlock').outerWidth();
                        $('#goalBlock').css('top', e.pageY + 30 + 'px');
                        $('#goalBlock').css('left', e.pageX - width / 2 + 'px');
                        $('#goalBlock').show();
                    });
                }, 500);

            }, function () {
                clearTimeout(timeout);
                $('#goalBlock').hide();
                $('#goalPic').attr('src', '');
            });

            $('#deleteButton').click(function () {

                var studyId = $(this).data('studyid');
                var modelId = $(this).data('modelid');

                if (confirm("Deleting a model cannot be undone. Continue?")) {
                    window.location = '/modelmanager/delete_model/' + studyId + '/' + modelId;
                    return true;
                } else {
                    return false;
                }
            });

            $('#modelPreview').click(function () {
                var title = $(this).data('title');
                var w = window.open($(this).attr('src'));
                setTimeout(function() {
                    w.document.title = "Preview of " + title;
                }, 50);
            });
        });
    </script>