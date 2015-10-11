<?php

/**
 * @author David Stefan
 */
class User extends CL_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    function signin() {
        $this->load->view('header');
        $this->load->view('signin');
        $this->load->view('footer');
    }
    
    function login() {
        
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        
        // Check if both parameters are present
        if ($email === NULL || $password === NULL) {
            show_error("Missing post parameters");
        }
        
        // Email will be false if given in wrong format
        if ($email === FALSE) {
            error_log("Email format error.");
            $this->location('/?signin_error');
        }
        
        $this->load->model('UserModel');
        
        $user = UserModel::loadByEmail($email);
        
        if ($user !== NULL && $user->getPassword() === md5($password)) {
            $this->session->set('userId', $user->getId());
            $this->location('/');
        } else {
            error_log("Wrong email or password entered.");
            $this->location('/?signin_error');
        }
    }
    
    function logout() {
        $this->session->remove('userId');
        $this->location('/');
    }
}
