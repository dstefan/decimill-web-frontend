<?php

if (!defined('SYSPATH')) {
    exit("No direct script access allowed!");
}

class Home extends CL_Controller {

    private $userId;
    
    function __construct() {
        parent::__construct();
        $this->userId = $this->session->get('userId');
        if ($this->userId === FALSE) {
            $this->location('/signin');
        }
    }
    
    function index() {
        
        $this->load->model('UserModel');
        $this->load->model('StudyModel');
        
        $user = UserModel::loadById($this->userId);
        $studies = StudyModel::loadByUser($user->getId());
        
        $this->assign('user', $user);
        $this->assign('studies', $studies);
        
        $this->load->view('header');
        $this->load->view('home');
        $this->load->view('footer');
    }
    
    function add_study() {
        
        $this->load->model('UserModel');
        $this->load->model('StudyModel');
        
        $user = UserModel::loadById($this->userId);
        $studies = StudyModel::loadByUser($user->getId());
        
        $this->assign('user', $user);
        $this->assign('studies', $studies);
        
        $this->load->view('header');
        $this->load->view('add_study');
        $this->load->view('footer');
    }

}
