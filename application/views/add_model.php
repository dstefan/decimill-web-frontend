
<? include_view('case_study_header'); ?>

<div id="content">

<div class="content-left">
    <? include_view('left_menu'); ?>
</div>

<div class="content-right">

    <div style="width: 350px; text-align: center; font-family: 'Roboto Condensed'; font-size: 25px; font-weight: 300; margin: 10px auto;">
        Create new model
    </div>

    <div class="content-block" style="width: 350px; margin: 0 auto;">
        <div style="padding: 30px;">
            <form action="/modelmanager/add_model" method="post">
                <input type="hidden" name="studyId" class="copyModelFormItem" value="<?= $study->getId() ?>" />
                <input type="text" name="modelTitle" style="width: 275px; box-sizing: content-box; margin-bottom: 7px;" placeholder="Title" />
                <input type="text" name="modelNamespace" style="width: 275px; box-sizing: content-box; margin-bottom: 7px;" placeholder="Namespace" />
                <input type="submit" class="button-grey" value="Create new model" style="box-sizing: content-box; width: 263px;" />
            </form>
        </div>
    </div>
    
    <div style="margin: 20px; text-align: center;">
        <em>or</em>
    </div>

    <div style="width: 350px; text-align: center; font-family: 'Roboto Condensed'; font-size: 25px; font-weight: 300; margin: 10px auto;">
        Copy existing
    </div>

    <div class="content-block" style="width: 350px; margin: 0 auto;">
        <div style="padding: 30px;">
            <form action="/modelmanager/copy_model" method="post">
                <input type="hidden" name="studyId" class="copyModelFormItem" value="<?= $study->getId() ?>" />
                <select type="text" name="modelId" class="copyModelFormItem" style="width: 281px; box-sizing: content-box; margin-bottom: 7px; padding: 5px;" placeholder="Title">
                    <option>Select model</option>
                    <? foreach ($allModels AS $m): ?>
                        <option value="<?= $m->getId() ?>"><?= $m->getTitle() ?> (<?= $m->getNamespace() ?>)</option>
                    <? endforeach; ?>
                </select>
                <input id="copyModelButton" type="submit" class="button-grey" value="Copy model" style="box-sizing: content-box; width: 263px;" />
            </form>
        </div>
    </div>

</div>

<script>

    $(function() {

    });

</script>