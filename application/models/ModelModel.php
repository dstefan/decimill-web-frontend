<?php

class ModelModel extends CL_Model {

    private $id;
    private $studyId;
    private $namespace;
    private $title;
    private $text;
    private $compiled;
    
    public function __construct() {
        parent::__construct();
        $this->text = "";
    }

    /**
     * @param stdClass $o
     * @return \ModelModel
     */
    public static function fromObject($o) {
        $model = new ModelModel();
        $model->setId($o->id);
        $model->setStudyId($o->studyId);
        $model->setTitle($o->title);
        $model->setNamespace($o->namespace);
        $model->setText($o->text);
        $model->setCompiled($o->compiled);
        return $model;
    }

    /**
     * @param int $id
     * @return \ModelModel
     */
    public static function loadById($id) {
        $db = cl_mysql();
        $db->select('model', '*', ['id' => $id]);
        if ($db->numRows() === 0) {
            return NULL;
        }
        return self::fromObject($db->fetchObject());
    }

    public static function loadByStudy($studyId) {
        $db = cl_mysql();
        $db->select('model', 'model.*', [
            'study' => ['study.id' => 'studyId']
                ], [
            'study.id' => $studyId
        ],  'ORDER BY `namespace`');
        $models = [];
        while ($o = $db->fetchObject()) {
            $models[] = self::fromObject($o);
        }
        return $models;
    }

    public static function loadAll() {
        $db = cl_mysql();
        $db->select('model', '*');
        $models = [];
        while ($o = $db->fetchObject()) {
            $models[] = self::fromObject($o);
        }
        return $models;
    }

    public function add() {
        $db = cl_mysql();
        $db->insert('model', [
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
        $db->update('model', [
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
        $db->query("DELETE FROM `model` WHERE `id` = $id");
    }

    public static function exists($id, $studyId) {
        $db = cl_mysql();
        return $db->exists('model', ['AND' => ['studyId' => $studyId, 'id' => $id]]);
    }

    private function setId($id) {
        $this->id = $id;
    }

    public function setStudyId($studyId) {
        $this->studyId = $studyId;
    }

    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
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

    public function getNamespace() {
        return $this->namespace;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getText() {
        return $this->text;
    }

    public function getCompiled() {
        return $this->compiled;
    }

}
