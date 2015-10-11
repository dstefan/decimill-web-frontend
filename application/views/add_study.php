
<style type="text/css">

    .case-button { cursor: pointer; background-color: #ffffe0; border: solid 1px #ffee66; border-radius: 4px; margin-bottom: 10px; }
    .case-button:last-of-type { margin-bottom: 0; }
    .case-button:hover { background-color: #ffffd0; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); }

    .study-block { padding: 10px 0 20px; border-bottom: solid 1px #ccc; }
    .study-block:last-child { border: none; }

</style>

<div id="content" style="padding-top: 20px;">

    <div class="content-left">

        <div style="height: 190px; background-color: #f5f6f7; border-radius: 4px; border: solid 1px #e8e9ea;">
        </div>

        <div style="color: #333;">
            <div style="font-size: 19px; border-bottom: solid 1px #f0f1f2; margin: 20px 0 0 0; padding: 0 0 3px 5px; font-weight: bold;">
                <?= $user->getName() ?> <?= $user->getSurname() ?>
            </div>
            <div style="border-top: solid 1px #fff; font-size: 14px; font-weight: 200; padding: 6px 0 0 5px;">
                <?= $user->getOrganisation() ?>
            </div>
            
            <div style="margin-top: 30px; padding: ">
                <a href="/add_study" class="button-grey" style="text-align: center; color: #666; float: right; width: 100%; box-sizing: border-box;">Add case study</a>
                <div style="clear: both;"></div>
            </div>
            
        </div>

    </div>

    <div class="content-right">

        To be implemented

    </div>

</div>

<script type="text/javascript">

    $(function() {

    });

</script>