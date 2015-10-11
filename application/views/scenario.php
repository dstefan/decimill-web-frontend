
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
                <a class="blink-red-small" id="deleteButton" data-studyid="<?= $study->getId() ?>" data-scenarioid="<?= $scenario->getId() ?>">delete</a>
                <a class="blink-blue-small" href="/scenario/<?= $scenario->getStudyId() ?>/<?= $scenario->getId() ?>/edit" style="padding-right: 7px;">edit</a>
            </div>
            <span class="scenario-title">
                <i class="fa fa-file-image-o" style="margin: 0 5px 0 0;"></i>
                <?= $scenario->getNamespace() ?>: <?= $scenario->getTitle() ?>
            </span>
        </div>

        <div class="markdown" style="padding: 15px 20px;">
            <?= $parser->text($scenario->getCompiled()) ?>
        </div>

    </div>

</div>

<script>
    
    $(function() {
        
        $('#deleteButton').click(function() {
            
            var studyId = $(this).data('studyid');
            var scenarioId = $(this).data('scenarioid');
            
            if (confirm("Deleting a scenario cannot be undone. Continue?")) {
                window.location = '/scenariomanager/delete_scenario/' + studyId + '/' + scenarioId;
                return true;
            } else {
                return false;
            }
        });
    });
    
</script>