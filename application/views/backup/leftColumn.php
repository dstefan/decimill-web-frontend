<div class="leftColumn">

    <div style="padding: 10px 20px;">

        <h2>
            <span class="icon sheet"></span>Models
        </h2>

        <div>
            <? foreach ($models AS $model): ?>
            <a href="/model/<?= $model->getId() ?>" class="linkButton editModel" data-modelid="<?= $model->getId() ?>"><?= $model->getName() ?></a>
            <? endforeach; ?>
        </div>

        <h2>
            <span class="icon sheet"></span>Scenarios
        </h2>

        <div>
            <? foreach ($scenarios AS $scenario): ?>
            <a href="/scenario/<?= $scenario->getId() ?>" class="linkButton editScenario" data-scenarioid="<?= $scenario->getId() ?>"><?= $scenario->getName() ?></a>
            <? endforeach; ?>
        </div>

        <div style="width: 100%; border-top: solid 1px #e0e1e2; border-bottom: solid 1px #fff; margin: 12px 0;"></div>

        <a href="/add_model" class="linkButton editModel">Add Model</a>
        <a href="/add_scenario" class="linkButton editModel">Add Scenario</a>
        
        <div style="width: 100%; border-top: solid 1px #e0e1e2; border-bottom: solid 1px #fff; margin: 12px 0;"></div>

        <a href="/change_case_study" class="linkButton editModel">Change Case Study</a>

        <div style="width: 100%; border-top: solid 1px #e0e1e2; border-bottom: solid 1px #fff; margin: 12px 0;"></div>

        <a href="/analysis" class="linkButton editModel">Analysis</a>

    </div>

</div>