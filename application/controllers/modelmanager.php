<?php

class ModelManager extends CL_Controller {

    function __construct() {
        parent::__construct();
    }

    function add_model() {

        $studyId = filter_input(INPUT_POST, 'studyId');
        $title = filter_input(INPUT_POST, 'modelTitle');
        $namespace = filter_input(INPUT_POST, 'modelNamespace');

        $this->load->model('ModelModel');

        $model = new ModelModel();
        $model->setStudyId($studyId);
        $model->setTitle($title);
        $model->setNamespace($namespace);
        $model->setText("");
        $model->add();

        $this->location('/model/' . $studyId . '/' . $model->getId());
    }

    function copy_model() {

        $studyId = filter_input(INPUT_POST, 'studyId');
        $modelId = filter_input(INPUT_POST, 'modelId');

        $this->load->model('ModelModel');

        $fromModel = ModelModel::loadById($modelId);

        $model = new ModelModel();
        $model->setStudyId($studyId);
        $model->setTitle($fromModel->getTitle());
        $model->setText($fromModel->getText());
        $model->setNamespace($fromModel->getNamespace());
        $model->add();

        $this->location('/model/' . $studyId . '/' . $model->getId());
    }

    /**
     * @AjaxCallable
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function compile_model() {

        $this->load->library('DecimillClient');
        $this->load->model('ModelModel');

        $id = filter_input(INPUT_POST, 'id');
        $text = filter_input(INPUT_POST, 'text');

        // Update model in database
        $model = ModelModel::loadById($id);
        $model->setText($text);
        $model->update();

        // Parse model using DeciMill
        $res = DecimillClient::call('-a', 'compileModel', '-m', $id);
        
        if (!$res->isError) {
            $model->setCompiled($res->body);
            $model->update();
        } else {
            $model->setCompiled('<div class="compile-error">Model was compiled with errors, please re-compile.</div>');
            $model->update();
        }
        return $res;
    }

    /**
     * @AjaxCallable
     * @AjaxMethod=POST
     * @AjaxAsync=TRUE
     */
    function update_model_title() {

        $id = filter_input(INPUT_POST, 'id');
        $title = filter_input(INPUT_POST, 'title');
        $namespace = filter_input(INPUT_POST, 'namespace');

        $this->load->model('ModelModel');

        $model = ModelModel::loadById($id);
        $model->setTitle($title);
        $model->setNamespace($namespace);
        $model->update();

        return [
            'id' => $id,
            'title' => $title,
            'namespace' => $namespace
        ];
    }
    
    function delete_model($studyId, $modelId) {
        $this->load->model('ModelModel');
        ModelModel::delete($modelId);
        $this->location('/study/' . $studyId);
    }

}
