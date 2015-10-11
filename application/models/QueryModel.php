<?php

class QueryModel extends CL_Model {

    private $id;
    private $studyId;
    private $title;
    private $text;
    private $compiled;

    public function __construct() {
        
    }

    /**
     * @param stdClass $o
     * @return \QueryModel
     */
    public static function fromObject($o) {
        $query = new QueryModel();
        $query->setId($o->id);
        $query->setStudyId($o->studyId);
        $query->setTitle($o->title);
        $query->setText($o->text);
        $query->setCompiled($o->compiled);
        return $query;
    }

    /**
     * @param int $id
     * @return \QueryModel
     */
    public static function loadById($id) {
        $db = cl_mysql();
        $db->select('query', '*', ['id' => $id]);
        if ($db->numRows() === 0) {
            return NULL;
        }
        return self::fromObject($db->fetchObject());
    }

    public static function loadByStudy($studyId) {
        $db = cl_mysql();
        $db->select('query', 'query.*', [
            'study' => ['study.id' => 'studyId']
                ], [
            'study.id' => $studyId
        ], 'ORDER BY `title`');
        $queries = [];
        while ($o = $db->fetchObject()) {
            $queries[] = self::fromObject($o);
        }
        return $queries;
    }

    public function add() {
        $db = cl_mysql();
        $db->insert('query', [
            'studyId' => $this->studyId,
            'title' => $this->title,
            'text' => $this->text,
            'compiled' => $this->compiled
        ]);
        $this->setId($db->getInsertId());
    }

    public function update() {
        $db = cl_mysql();
        $db->update('query', [
            'title' => $this->title,
            'text' => $this->text,
            'compiled' => $this->compiled
                ], [
            'id' => $this->id
        ]);
    }
    
    public static function delete($id) {
        $db = cl_mysql();
        $db->query("DELETE FROM `query` WHERE `id` = $id");
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

    public function getText() {
        return $this->text;
    }

    public function getCompiled() {
        return $this->compiled;
    }

}
