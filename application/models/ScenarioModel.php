<?php

class ScenarioModel extends CL_Model {

    private $id;
    private $studyId;
    private $title;
    private $namespace;
    private $text;
    private $compiled;

    /**
     * @param stdClass $o
     * @returns \ScenarioModel
     */
    public static function fromObject($o) {
        $scenario = new ScenarioModel();
        $scenario->setId($o->id);
        $scenario->setStudyId($o->studyId);
        $scenario->setTitle($o->title);
        $scenario->setNamespace($o->namespace);
        $scenario->setText($o->text);
        $scenario->setCompiled($o->compiled);
        return $scenario;
    }

    public static function loadById($id) {
        $db = cl_mysql();
        $db->select('scenario', '*', ['id' => $id]);
        if ($db->numRows() === 0) {
            return NULL;
        }
        return self::fromObject($db->fetchObject());
    }
    
    public static function loadByStudy($studyId) {
        $db = cl_mysql();
        $db->select('scenario', 'scenario.*', [
            'study' => ['study.id' => 'studyId']
                ], [
            'study.id' => $studyId
        ], 'ORDER BY `namespace`');
        $scenarios = [];
        while ($o = $db->fetchObject()) {
            $scenarios[] = self::fromObject($o);
        }
        return $scenarios;
    }
    
    public function add() {
        $db = cl_mysql();
        $db->insert('scenario', [
            'studyId' => $this->studyId,
            'namespace' => $this->namespace,
            'title' => $this->title,
            'text' => $this->text,
            'compiled' => $this->compiled
        ]);
        $this->setId($db->getInsertId());
    }
    
    public function update() {
        $db = cl_mysql();
        $db->update('scenario', [
            'title' => $this->title,
            'namespace' => $this->namespace,
            'text' => $this->text,
            'compiled' => $this->compiled
                ], [
            'id' => $this->id
        ]);
    }
    
    public static function delete($id) {
        $db = cl_mysql();
        $db->query("DELETE FROM `scenario` WHERE `id` = $id");
    }

    private function setId($id) {
        $this->id = $id;
    }

    public function setStudyId($studyId) {
        $this->studyId = $studyId;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setCompiled($compiled) {
        $this->compiled = $compiled;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getStudyId() {
        return $this->studyId;
    }

    public function getTitle() {
        return $this->title;
    }
    
    public function getNamespace() {
        return $this->namespace;
    }

    public function getText() {
        return $this->text;
    }

    public function getCompiled() {
        return $this->compiled;
    }



}
