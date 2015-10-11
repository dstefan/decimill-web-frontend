<?php

class ScenarioManager extends CL_Controller {

    function __construct() {
        parent::__construct();
    }

    function add_scenario() {

        $studyId = filter_input(INPUT_POST, 'studyId');
        $title = filter_input(INPUT_POST, 'scenarioTitle');
        $namespace = filter_input(INPUT_POST, 'scenarioNamespace');

        $this->load->model('ScenarioModel');
        
        $scenario = new ScenarioModel();
        $scenario->setStudyId($studyId);
        $scenario->setTitle($title);
        $scenario->setNamespace($namespace);
        $scenario->setText("");
        $scenario->add();

        $this->location('/scenario/' . $studyId . '/' . $scenario->getId());
    }

    /**
     * @AjaxCallable
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function compile_scenario() {
        
        $this->load->library('DecimillClient');
        $this->load->model('ScenarioModel');

        $id = filter_input(INPUT_POST, 'id');
        $text = filter_input(INPUT_POST, 'text');

        $scenario = ScenarioModel::loadById($id);
        $scenario->setText($text);
        $scenario->update();

        $res = DecimillClient::call('-a', 'compileScenario', '-s', $id);

        if (!$res->isError) {
            $scenario->setCompiled($res->body);
            $scenario->update();
        } else {
            $scenario->setCompiled('<div class="compile-error">Scenario was compiled with errors, please re-compile.</div>');
            $scenario->update();
        }
        return $res;
    }

    /**
     * @AjaxCallable
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function update_scenario_title() {
        
        $id = filter_input(INPUT_POST, 'id');
        $title = filter_input(INPUT_POST, 'title');
        $namespace = filter_input(INPUT_POST, 'namespace');

        $this->load->model('ScenarioModel');

        $scenario = ScenarioModel::loadById($id);
        $scenario->setTitle($title);
        $scenario->setNamespace($namespace);
        $scenario->update();

        return [
            'id' => $id,
            'title' => $title,
            'namespace' => $namespace
        ];
    }

    function delete_scenario($studyId, $scenarioId) {
        $this->load->model('ScenarioModel');
        ScenarioModel::delete($scenarioId);
        $this->location('/study/' . $studyId);
    }
}
