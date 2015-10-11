<?php

class CaseManager extends CL_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    function add_case() {
        
        $title = filter_input(INPUT_POST, 'title');
        $description = filter_input(INPUT_POST, 'description');
        $userId = $this->session->get('userId');
        
        // Check if both parameters are present
        if ($title === NULL || $description === NULL) {
            show_error("Missing post parameters");
        }
        
        $this->load->model('CaseModel');
        
        $case = new CaseModel();
        $case->setTitle($title);
        $case->setDescription($description);
        $case->add($userId);
        
        $this->location('/');
    }
}

