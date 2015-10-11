<?php

class ContextManager extends CL_Controller {

    private $db = null;

    function __construct() {
        parent::CL_Controller();
        $this->load->model('ModelModel');
        $this->load->model('ScenarioModel');
        $this->load->model('ContextModel');
        $this->load->model('QueryModel');
        $this->load->model('TempModel');
        $this->db = CL_MySQL::getInstance();
    }

    function open_case() {
        $caseName = filter_input(INPUT_POST, 'caseName');
        $this->load->model('CaseModel');
        $caseId = CaseModel::add($caseName);
        $this->session->set('caseId', $caseId);
        $this->location('/workbench');
    }

    /**
     * @AjaxCallable=TRUE
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function add_model() {

        $this->load->library('DecimillClient');

        $id = $this->session->getId();
        $caseId = $this->session->get('caseId');
        $text = filter_input(INPUT_POST, 'text');

        TempModel::add($id, $caseId, $text);
        $info = TempModel::getModelInfo($id, $caseId);

        if ($info['isError']) {
            return $info;
        }

        ModelModel::add($info['body']['id'], $caseId, $info['body']['name'], $text);
        TempModel::remove($id, $caseId);
        return $info;
    }
    
    function delete_model() {
        $caseId = $this->session->get('caseId');
        $id = filter_input(INPUT_POST, 'id');
        ModelModel::delete($id, $caseId);
        $this->location('/workbench');
    }

    /**
     * @AjaxCallable=TRUE
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function update_model_text() {

        $caseId = $this->session->get('caseId');
        $id = filter_input(INPUT_POST, 'id');
        $text = filter_input(INPUT_POST, 'text');

        ModelModel::updateText($id, $caseId, $text);
        $info = ModelModel::getInfo($id, $caseId);

        if (!$info['isError']) {
            $newId = $info['body']['id'];
            $name = $info['body']['name'];
            ModelModel::updateId($id, $caseId, $newId);
            ModelModel::updateName($newId, $caseId, $name);
            return $info;
        }

        return $info;
    }
    
    /**
     * @AjaxCallable=TRUE
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function add_scenario() {

        $this->load->library('DecimillClient');

        $id = $this->session->getId();
        $caseId = $this->session->get('caseId');
        $text = filter_input(INPUT_POST, 'text');

        TempModel::add($id, $caseId, $text);
        $info = TempModel::getScenarioInfo($id, $caseId);

        if ($info['isError']) {
            return $info;
        }

        ScenarioModel::add($info['body']['id'], $caseId, $info['body']['name'], $text);
        TempModel::remove($id, $caseId);
        return $info;
    }
    
    function delete_scenario() {
        $caseId = $this->session->get('caseId');
        $id = filter_input(INPUT_POST, 'id');
        ScenarioModel::delete($id, $caseId);
        $this->location('/workbench');
    }

    /**
     * @AjaxCallable=TRUE
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function update_scenario_text() {

        $caseId = $this->session->get('caseId');
        $id = filter_input(INPUT_POST, 'id');
        $text = filter_input(INPUT_POST, 'text');

        ScenarioModel::updateText($id, $caseId, $text);
        $info = ScenarioModel::getInfo($id, $caseId);
        
        if (!$info['isError']) {
            $newId = $info['body']['id'];
            $name = $info['body']['name'];
            ScenarioModel::updateId($id, $caseId, $newId);
            ScenarioModel::updateName($newId, $caseId, $name);
            return $info;
        }

        return $info;
    }

    /**
     * @AjaxCallable=TRUE
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function get_query() {

        $caseId = $this->session->get('caseId');

        $res = $this->db->select('query', 'text', [
            'caseId' => $caseId
        ]);

        // Handle possible error
        if (!$res) {
            throwErrorAndExit($this->db->getError());
        }

        return [
            'body' => $this->db->fetchObject()->text,
            'isError' => FALSE,
            'errCode' => 0
        ];
    }

    /**
     * @AjaxCallable=TRUE
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function set_query() {

        $caseId = $this->session->get('caseId');
        $text = filter_input(INPUT_POST, 'text');

        $queryExists = $this->db->exists('query', [
            'caseId' => $caseId
        ]);

        if ($queryExists) {
            $this->db->update('query', [
                'text' => $text
                    ], [
                'caseId' => $caseId
            ]);
        } else {
            $this->db->insert('query', [
                'caseId' => $caseId,
                'text' => $text
            ]);
        }
    }

    /**
     * @AjaxCallable=TRUE
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function run_query() {

        $caseId = $this->session->get('caseId');
        $text = filter_input(INPUT_POST, 'text');
        
        QueryModel::add($caseId, $text);
        $res = QueryModel::run($caseId);
        
        return $res;

//        // Retrieve script path
//        $path = $this->config->get_item('main', 'decimill_path');
//
//        $out = NULL;
//        $res = NULL;
//
//        // Execute query
//        exec('java -jar ' . $path . 'decimill-client.jar -a runQuery -c ' . $caseId, $out, $res);
//
//        if ($res === 0) {
//            return [
//                'body' => json_decode($out[0])->body,
//                'isError' => false,
//                'errCode' => 0
//            ];
//        } else {
//            return [
//                'body' => json_decode($out[0])->body,
//                'isError' => true,
//                'errCode' => $res
//            ];
//        }
    }

}
