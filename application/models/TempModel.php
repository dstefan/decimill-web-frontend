<?php

class TempModel extends CL_Model {

    private $id;
    private $caseId;
    private $text;
    private $timestamp;

    public function __construct($o) {
        $this->id = $o->id;
        $this->caseId = $o->caseId;
        $this->text = $o->text;
        $this->timestamp = $o->timestamp;
    }
  
    public static function add($id, $caseId, $text) {
        $db = CL_MySQL::getInstance();
        $db->insert('temp', [
            'id' => $id,
            'caseId' => $caseId,
            'text' => $text,
            'timestamp' => ['NOW' => []]
        ], TRUE);
    }
    
    public static function remove($id, $caseId) {
        $db = CL_MySQL::getInstance();
        $db->query("DELETE FROM `temp` WHERE `id` = '$id' AND `caseId` = $caseId");
    }
    
    public static function getModelInfo($id, $caseId) {
        CL_Loader::get_instance()->library('DecimillClient');
        $res = DecimillClient::call("-t", $id, "-c", $caseId, "-a", "getTempModelInfo");
        return json_decode($res, TRUE);
    }
    
    public static function getScenarioInfo($id, $caseId) {
        CL_Loader::get_instance()->library('DecimillClient');
        $res = DecimillClient::call("-t", $id, "-c", $caseId, "-a", "getTempScenarioInfo");
        return json_decode($res, TRUE);
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

}
