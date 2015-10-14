<?php

/**
 * @author David Stefan
 */
class Test extends CL_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function client() {
        $this->load->library('DecimillClient');
        $client = new DecimillClient();
        $client->compileModel(2, 'UCL', 'This model `Goal 1 <- Goal 3, Goal 5` is nice.');
    }
        
}
