<?= include_view('header'); ?>

<style type="text/css">
    .case-button { cursor: pointer; background-color: #ffffe0; border: solid 1px #ffee66; border-radius: 4px; margin-bottom: 10px; }
    .case-button:last-of-type { margin-bottom: 0; }
    .case-button:hover { background-color: #ffffd0; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); }
</style>

<script>
    $(function() {
        $('.case-button').click(function() {
            var caseId = $(this).data('caseid');
            console.log(caseId);
            window.location = '/case_study/' + caseId;
        });
    });
</script>

<?= include_view('heading'); ?>

<div class="content-box content-box-outline" style="border-radius: 0 0 4px 4px; margin-top: -1px;">
    <div class="content-box-wrapper" style="font-family: 'Open Sans', sans-serif;">
        <div style="font-size: 18px; border-bottom: solid 1px #f0f1f2; padding-bottom: 5px;">
            <?= $user->getName() ?> <?= $user->getSurname() ?>
        </div>
        <div style="font-size: 12px; font-weight: 200; padding-top: 3px;">
            <?= $user->getOrganisation() ?>
        </div>
    </div>
</div>

<div class="content-box-label">
    <div class="content-box-label-wrapper">
        My case studies
    </div>
</div>

<div class="content-box content-box-outline">
    <div class="content-box-wrapper">
        <? foreach ($cases AS $case): ?>
            <div class="case-button" data-caseid="<?= $case->getId() ?>">
                <div style="padding: 10px;">
                    <div style="font-family: 'Open Sans', sans-serif; font-size: 18px; margin-bottom: 8px;">
                        <?= $case->getTitle() ?>
                    </div>
                    <div>
                        <?= $case->getDescription() ?>
                    </div>
                </div>
            </div>
        <? endforeach ?>
    </div>
    <div class="content-box-footer">
        <a href="/add_study" class="button-grey" style="float: right;">Add case study</a>
        <div style="clear: both;"></div>
    </div>
</div>

<?= include_view('footer'); ?>