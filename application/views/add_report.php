
<? include_view('case_study_header'); ?>

<div id="content">

<div class="content-left">
    <? include_view('left_menu'); ?>
</div>

<div class="content-right">

    <div style="width: 350px; text-align: center; font-family: 'Roboto Condensed'; font-size: 25px; font-weight: 300; margin: 10px auto;">
        Create new report
    </div>

    <div class="content-block" style="width: 350px; margin: 0 auto;">
        <div style="padding: 30px;">
            <form action="/querymanager/add_query" method="post">
                <input type="hidden" name="studyId" class="copyModelFormItem" value="<?= $study->getId() ?>" />
                <input type="text" name="title" style="width: 275px; box-sizing: content-box; margin-bottom: 7px;" placeholder="Title" />
                <input type="submit" class="button-grey" value="Create new report" style="box-sizing: content-box; width: 263px;" />
            </form>
        </div>
    </div>

</div>