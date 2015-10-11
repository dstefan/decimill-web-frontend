
<div class="content-menu-box">

    <div class="content-menu-box-header">
        <i class="fa fa-code-fork" style="margin: 0 7px 0 2px;"></i> Models
    </div>

    <? foreach ($models AS $m): ?>
        <a class="content-menu-box-item<?= @$model && $m->getId() === $model->getId() ? ' active' : '' ?>"
           href="/model/<?= $m->getStudyId() ?>/<?= $m->getId() ?>">
            <div class="content-menu-box-item-wrapper modelMenuItem" data-modelid="<?= $m->getId() ?>">
                <?= $m->getNamespace() ?>: <?= $m->getTitle() ?>
            </div>
        </a>
    <? endforeach; ?>

    <a href="/add_model/<?= $study->getId() ?>" class="content-menu-box-item">
        <div class="content-menu-box-item-wrapper" style="text-align: center;">
            <i class="fa fa-plus" style="font-size: 14px; color: #555;"></i> Add model
        </div>
    </a>

</div>

<div class="content-menu-box" style="margin-top: 20px;">

    <div class="content-menu-box-header">
        <i class="fa fa-file-image-o"></i> Scenarios
    </div>

    <? foreach ($scenarios AS $s): ?>
        <a class="content-menu-box-item<?= @$scenario && $s->getId() === $scenario->getId() ? ' active' : '' ?>"
           href="/scenario/<?= $m->getStudyId() ?>/<?= $s->getId() ?>">
            <div class="content-menu-box-item-wrapper scenarioMenuItem" data-scenarioid="<?= $s->getId() ?>">
                <?= $s->getNamespace() ?>: <?= $s->getTitle() ?>
            </div>
        </a>
    <? endforeach; ?>

    <a href="/add_scenario/<?= $study->getId() ?>" class="content-menu-box-item">
        <div class="content-menu-box-item-wrapper" style="text-align: center;">
            <i class="fa fa-plus" style="font-size: 14px; color: #555;"></i> Add scenario
        </div>
    </a>


</div>

<div class="content-menu-box" style="margin-top: 20px;">

    <div class="content-menu-box-header">
        <i class="fa fa-file-text-o"></i> Reports
    </div>

    <? foreach ($queries AS $q): ?>
        <a class="content-menu-box-item<?= @$query && $q->getId() === $query->getId() ? ' active' : '' ?>"
           href="/report/<?= $q->getStudyId() ?>/<?= $q->getId() ?>">
            <div class="content-menu-box-item-wrapper queryMenuItem" data-queryid="<?= $q->getId() ?>">
                <?= $q->getTitle() ?>
            </div>
        </a>
    <? endforeach; ?>

    <a href="/add_report/<?= $study->getId() ?>" class="content-menu-box-item">
        <div class="content-menu-box-item-wrapper" style="text-align: center;">
            <i class="fa fa-plus" style="font-size: 14px; color: #555;"></i> Add report
        </div>
    </a>

</div>
