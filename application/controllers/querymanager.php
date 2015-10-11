<?php

class QueryManager extends CL_Controller {

    function __construct() {
        parent::__construct();
    }

    function add_query() {

        $studyId = filter_input(INPUT_POST, 'studyId');
        $title = filter_input(INPUT_POST, 'title');

        $this->load->model('QueryModel');

        $query = new QueryModel();
        $query->setStudyId($studyId);
        $query->setTitle($title);
        $query->setText("");
        $query->add();

        $this->location('/report/' . $studyId . '/' . $query->getId());
    }

    /**
     * @AjaxCallable
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function compile_query() {

        $this->load->library('DecimillClient');
        $this->load->model('QueryModel');

        $id = filter_input(INPUT_POST, 'id');
        $text = filter_input(INPUT_POST, 'text');

        // Update model in database
        $query = QueryModel::loadById($id);
        $query->setText($text);
        $query->update();

        // Parse model using DeciMill
        $res = DecimillClient::call('-a', 'compileQuery', '-q', $id);
        
        if (!$res->isError) {
            $query->setCompiled($res->body);
            $query->update();
        } else {
            $query->setCompiled('<div class="compile-error">Report was compiled with errors, please re-compile.</div>');
            $query->update();
        }
        return $res;
    }
    
    /**
     * @AjaxCallable
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function update_query_title() {

        $id = filter_input(INPUT_POST, 'id');
        $title = filter_input(INPUT_POST, 'title');

        $this->load->model('QueryModel');

        $query = QueryModel::loadById($id);
        $query->setTitle($title);
        $query->update();

        return [
            'id' => $id,
            'title' => $title
        ];
    }
    
    function delete_query($studyId, $queryId) {
        $this->load->model('QueryModel');
        QueryModel::delete($queryId);
        $this->location('/study/' . $studyId);
    }

}
