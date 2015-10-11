<?php

/**
 * @author David Stefan
 */
class Test extends CL_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function file() {
        echo var_dump(file_exists('C:/Users/David/Dev/dmtools/web/application/images/models/7/full.png'));
    }
    
    public function bool() {
        $val = 0.001;
        if ($val) {
            echo "yes";
        } else {
            echo "no";
        }
    }
    
    public function parsedown() {
        $this->load->library('Parsedown');
        $parser = new Parsedown();
        echo $parser->text("**Hello**\n\nThis is an inline `Code` here.\n    Minimise CO2 Emissions\n    co2_emissions\nEnd _ending_.[Link](http://www.google.com).");
    }
    
    public function markdown_js() {
        $this->load->view('markdown_js');
    }
    
    public function gen() {
//        require APPPATH . 'libraries/MarkdownInterface.php';
//        require APPPATH . 'libraries/MarkdownExtra.php';
//        require APPPATH . 'libraries/Markdown.php';
        $this->load->library('MarkdownInterface');
        $this->load->library('Markdown');
        $this->load->library('MarkdownExtra');
        
        echo Markdown::defaultTransform("*Test*");
    }

    public function user() {

        $this->load->model('UserModel');
        
//        $user = new UserModel();
//        $user->setEmail('ania.obolewicz@gmail.com');
//        $user->setPassword(md5('AniaIsCool'));
//        
//        if ($user->save() === FALSE) {
//            echo "User with email " . $user->getEmail() . " already exists!";
//            return;
//        }
//        
//        echo $user->getId();
        
        $user = UserModel::loadById(3);
        
        $user->setEmail('ania.obolewicz@gmail.com');
        $user->setPassword(md5('AniaIsCool'));
        $user->save();
        
        $user = UserModel::loadById(1);
        
        if ($user !== NULL) {
            echo $user->getId();
            echo $user->getEmail();
            echo $user->getPassword() == md5('K8rnatt0');
        }
    }

    function case_study() {
        
        $this->load->model('CaseModel');
        print_r(CaseModel::loadByUser(1));
    }
    
    function models() {
        
        $this->load->model('ModelModel');
        $models = ModelModel::loadByCase(1);
        print_r($models);
    }
    
    function client() {
        
        $this->load->library('DecimillClient');
        DecimillClient::call("-a", "parseModel", "-m", "1");
    }
    
    function chart() {
        $this->load->view('backup/chart');
    }
        
}
