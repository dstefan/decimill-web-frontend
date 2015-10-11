<?php

if (!defined('SYSPATH')) {
    exit("No direct script access allowed!");
}

class Profile extends CL_Controller {

    function __construct() {
        parent::__construct();
    }

    function index($userId) {
        echo "user: " . $userId;
    }

}
