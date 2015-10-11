<?php

class StudyModel extends CL_Model {

    private $id;
    private $title;
    private $description;

    /**
     * @param stdClass $o
     * @return CaseModel
     */
    public static function fromObject($o) {
        $study = new StudyModel();
        $study->setId($o->id);
        $study->setTitle($o->title);
        $study->setDescription($o->description);
        return $study;
    }

    public static function loadById($id) {

        $db = CL_MySQL::getInstance();
        $db->select('study', '*', [
            'id' => $id
        ]);

        if ($db->numRows() === 0) {
            return NULL;
        }

        return self::fromObject($db->fetchObject());
    }

    public static function loadByUser($userId) {

        $db = CL_MySQL::getInstance();
        $db->select('study', '*', [
            'study_to_user' => ['studyId' => 'id']
                ], [
            'study_to_user.userId' => $userId
        ]);

//        echo $db->getQuery();
//        exit();

        $studies = [];

        while ($o = $db->fetchObject()) {
            $studies[] = self::fromObject($o);
        }

        return $studies;
    }

    public function add($userId) {

        $db = cl_mysql();
        $db->insert('study', [
            'title' => $this->title,
            'description' => $this->description
        ]);
        
        $this->setId($db->getInsertId());
        
        $db->insert('study_to_user', [
            'studyId' => $this->getId(),
            'userId' => $userId
        ]);
    }

    private function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

}
