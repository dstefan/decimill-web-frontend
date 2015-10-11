<?php

class Editor extends CL_Controller {

    function __construct() {
        
        parent::CL_Controller();
        $this->load->model('CaseModel');
        $this->load->model('ModelModel');
        $this->load->model('ScenarioModel');
        $this->load->model('QueryModel');
        $this->load->model('ContextModel');
        $this->db = CL_MySQL::getInstance();
        
        if (!$this->session->is_set('caseId')) {
            $this->location('/');
        }
    }
    
    function workbench() {
        
        $caseId = $this->session->get('caseId');
        
        $models = ModelModel::loadAll($caseId);
        $scenarios = ScenarioModel::loadAll($caseId);
        $case = CaseModel::load($caseId);
        
        $this->assign('case', $case);
        $this->assign('models', $models);
        $this->assign('scenarios', $scenarios);
        
        $this->load->view('workbench');
    }
    
    function model($modelId) {
        
        $caseId = $this->session->get('caseId');
        
        $models = ModelModel::loadAll($caseId);
        $scenarios = ScenarioModel::loadAll($caseId);
        $case = CaseModel::load($caseId);
        $model = ModelModel::load($modelId, $caseId);
        
        $this->assign('models', $models);
        $this->assign('scenarios', $scenarios);
        $this->assign('case', $case);
        $this->assign('model', $model);
        
        $this->load->view('model_editor');
    }
    
    function scenario($scenarioId) {
        
        $caseId = $this->session->get('caseId');
        
        $models = ModelModel::loadAll($caseId);
        $scenarios = ScenarioModel::loadAll($caseId);
        $case = CaseModel::load($caseId);
        $scenario = ScenarioModel::load($scenarioId, $caseId);
        
        $this->assign('models', $models);
        $this->assign('scenarios', $scenarios);
        $this->assign('case', $case);
        $this->assign('scenario', $scenario);
        
        $this->load->view('scenario_editor');
    }
    
    function analysis() {
        
        $caseId = $this->session->get('caseId');
        
        $models = ModelModel::loadAll($caseId);
        $scenarios = ScenarioModel::loadAll($caseId);
        $case = CaseModel::load($caseId);
        $query = QueryModel::load($caseId);
        
        $this->assign('models', $models);
        $this->assign('scenarios', $scenarios);
        $this->assign('case', $case);
        $this->assign('query', $query);
        
        $this->load->view('analysis_editor');
    }
    
    function add_model() {
        
        $caseId = $this->session->get('caseId');
        
        $models = ModelModel::loadAll($caseId);
        $scenarios = ScenarioModel::loadAll($caseId);
        $case = CaseModel::load($caseId);
        
        $this->assign('models', $models);
        $this->assign('scenarios', $scenarios);
        $this->assign('case', $case);
        
        $this->load->view('model_add');
    }
    
    function add_scenario() {
        
        $caseId = $this->session->get('caseId');
        
        $models = ModelModel::loadAll($caseId);
        $scenarios = ScenarioModel::loadAll($caseId);
        $case = CaseModel::load($caseId);
        
        $this->assign('models', $models);
        $this->assign('scenarios', $scenarios);
        $this->assign('case', $case);
        
        $this->load->view('scenario_add');
    }
    
    function change_case_study() {
        $this->session->remove('caseId');
        $this->location('/');
    }

}
