<?= include_view('header'); ?>

<style>
    .model-button { cursor: pointer; width: 165px; height: 120px; background-color: #ffffe0; border: solid 1px #ffee66; border-radius: 4px; margin: 0 10px 10px 0; color: #333; }
    a.model-button { text-decoration: none; }
    .model-button:last-child { margin-right: 0; }
    .model-button:hover { background-color: #ffffd0; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); }
</style>

<script>
</script>

<?= include_view('heading'); ?>

<div class="content-box content-box-outline" style="border-radius: 0 0 4px 4px; margin-top: -1px;">
    <div class="content-box-wrapper" style="font-family: 'Open Sans', sans-serif;">
        <div style="font-size: 18px; border-bottom: solid 1px #f0f1f2; padding-bottom: 5px;">
            <?= $case->getTitle() ?>
        </div>
        <div style="font-size: 16px; font-weight: 200; padding-top: 3px;">
            <?= $case->getDescription() ?>
        </div>
    </div>
</div>

<div>
    <div class="content-box-label">
        <div class="content-box-label-wrapper">
            Models
        </div>
    </div>
    <div class="content-box content-box-outline">
        <div class="content-box-wrapper">
            <? foreach ($models AS $model): ?>
                <a class="model-button" href="/model/<?= $model->getId() ?>" style="float: left;">
                    <div style="padding: 22px 10px 0;">
                        <div style="font-family: 'Open Sans', sans-serif; font-size: 35px; text-align: center; margin-bottom: 7px;">
                            <?= $model->getNamespace() ?>
                        </div>
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align: center;">
                            <?= $model->getTitle() ?>
                        </div>
                    </div>
                </a>
            <? endforeach ?>
            <div style="clear: both;"></div>
        </div>
        <div class="content-box-footer">
            <div class="content-box-footer-buttons">
                <a href="/add_model/<?= $case->getId() ?>" class="button-grey">Add model</a>
            </div>
        </div>
    </div>
</div>

<?= include_view('footer'); ?>