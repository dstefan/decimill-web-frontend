<?php

if (!defined('SYSPATH')) {
    exit("No direct script access allowed!");
}

class Casestudy extends CL_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('StudyModel');
        $this->load->model('ModelModel');
        $this->load->model('ScenarioModel');
        $this->load->model('QueryModel');

        $this->load->library('MarkdownInterface');
        $this->load->library('Markdown');
        $this->load->library('MarkdownExtra');
    }

    function study($studyId) {

        $study = StudyModel::loadById($studyId);
        $this->assign('title', $study->getTitle());

        $this->assign('study', $study);
        $this->assign('models', ModelModel::loadByStudy($studyId));
        $this->assign('scenarios', ScenarioModel::loadByStudy($studyId));
        $this->assign('queries', QueryModel::loadByStudy($studyId));

        $this->load->view('header');
        $this->load->view('study');
        $this->load->view('footer');
    }

    function model($studyId, $modelId, $action = "") {

        $model = ModelModel::loadById($modelId);

        if ($action !== 'edit' && $model->getCompiled() === NULL) {
            $this->location('/model/' . $studyId . '/' . $modelId . '/edit');
        }

        $this->load->library('Parsedown');
        $parser = new Parsedown();

        $this->assign('parser', $parser);
        $this->assign('model', $model);
        $this->assign('title', $model->getNamespace() . ": " . $model->getTitle());

        $this->assign('study', StudyModel::loadById($studyId));
        $this->assign('models', ModelModel::loadByStudy($studyId));
        $this->assign('scenarios', ScenarioModel::loadByStudy($studyId));
        $this->assign('queries', QueryModel::loadByStudy($studyId));

        if ($action === "edit" || $model->getCompiled() === NULL) {
            $this->load->view('header');
            $this->load->view('model_edit');
            $this->load->view('footer');
        } else {
            $this->load->view('header');
            $this->load->view('model');
            $this->load->view('footer');
        }
    }

    function add_model($studyId) {

        $this->load->model('StudyModel');
        $this->load->model('ModelModel');

        $this->assign('study', StudyModel::loadById($studyId));
        $this->assign('models', ModelModel::loadByStudy($studyId));
        $this->assign('scenarios', ScenarioModel::loadByStudy($studyId));
        $this->assign('queries', QueryModel::loadByStudy($studyId));
        $this->assign('allModels', $allModels = ModelModel::loadAll());

        $this->load->view('header');
        $this->load->view('add_model');
        $this->load->view('footer');
    }

    function scenario($studyId, $scenarioId, $action = "") {

        $scenario = ScenarioModel::loadById($scenarioId);

        if ($action !== 'edit' && $scenario->getCompiled() === NULL) {
            $this->location('/scenario/' . $studyId . '/' . $scenarioId . '/edit');
        }

        $this->load->library('Parsedown');
        $parser = new Parsedown();

        $this->assign('parser', $parser);
        $this->assign('scenario', $scenario);
        $this->assign('title', $scenario->getNamespace() . ": " . $scenario->getTitle());

        $this->assign('study', StudyModel::loadById($studyId));
        $this->assign('models', ModelModel::loadByStudy($studyId));
        $this->assign('scenarios', ScenarioModel::loadByStudy($studyId));
        $this->assign('queries', QueryModel::loadByStudy($studyId));

        if ($action === "edit" || $scenario->getCompiled() === NULL) {
            $this->load->view('header');
            $this->load->view('scenario_edit');
            $this->load->view('footer');
        } else {
            $this->load->view('header');
            $this->load->view('scenario');
            $this->load->view('footer');
        }
    }

    function add_scenario($studyId) {

        $this->assign('study', StudyModel::loadById($studyId));
        $this->assign('models', ModelModel::loadByStudy($studyId));
        $this->assign('scenarios', ScenarioModel::loadByStudy($studyId));
        $this->assign('queries', QueryModel::loadByStudy($studyId));

        $this->load->view('header');
        $this->load->view('add_scenario');
        $this->load->view('footer');
    }

    function report($studyId, $queryId, $action = "") {

        $query = QueryModel::loadById($queryId);

        if ($action !== 'edit' && $query->getCompiled() === NULL) {
            $this->location('/report/' . $studyId . '/' . $queryId . '/edit');
        }

        $this->load->library('Parsedown');
        $parser = new Parsedown();

        $this->assign('parser', $parser);
        $this->assign('query', $query);
        $this->assign('title', $query->getTitle());

        $this->assign('study', StudyModel::loadById($studyId));
        $this->assign('models', ModelModel::loadByStudy($studyId));
        $this->assign('scenarios', ScenarioModel::loadByStudy($studyId));
        $this->assign('queries', QueryModel::loadByStudy($studyId));

        if ($action === "edit" || $query->getCompiled() === NULL) {
            $this->load->view('header');
            $this->load->view('report_edit');
            $this->load->view('footer');
        } else {
            $this->load->view('header');
            $this->load->view('report');
            $this->load->view('footer');
        }
    }

    function add_report($studyId) {

        $this->assign('study', StudyModel::loadById($studyId));
        $this->assign('models', ModelModel::loadByStudy($studyId));
        $this->assign('scenarios', ScenarioModel::loadByStudy($studyId));
        $this->assign('queries', QueryModel::loadByStudy($studyId));

        $this->load->view('header');
        $this->load->view('add_report');
        $this->load->view('footer');
    }

}
