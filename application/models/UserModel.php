<?php

class UserModel {

    private $id;
    private $email;
    private $password;
    private $name;
    private $surname;
    private $organisation;

    public static function fromObject($o) {
        $user = new UserModel();
        $user->setId($o->id);
        $user->setEmail($o->email);
        $user->setPassword($o->password);
        $user->setName($o->name);
        $user->setSurname($o->surname);
        $user->setOrganisation($o->organisation);
        return $user;
    }

    /**
     * @param int $id
     * @return UserModel
     */
    public static function loadById($id) {

        $db = cl_mysql();
        $db->select('user', '*', [
            'id' => $id
        ]);

        if (!$db->numRows()) {
            return NULL;
        }

        return self::fromObject($db->fetchObject());
    }
    
    /**
     * @param string $email
     * @return UserModel
     */
    public static function loadByEmail($email) {

        $db = cl_mysql();
        $db->select('user', '*', [
            'email' => $email
        ]);

        if (!$db->numRows()) {
            return NULL;
        }

        return self::fromObject($db->fetchObject());
    }

    public function save() {
        if ($this->id === NULL) {
            $this->add();
        } else {
            $this->update();
        }
    }

    private function add() {

        $db = cl_mysql();

        // Return false is user with same email already exists
        if ($db->exists('user', ['email' => $this->email])) {
            return FALSE;
        }

        // Otherwise insert user into database
        $db->insert('user', [
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
            'surname' => $this->surname,
            'organisation' => $this->organisation
        ]);

        $this->setId($db->getInsertId());
    }

    private function update() {

        $db = cl_mysql();

        $db->update('user', [
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
            'surname' => $this->surname,
            'organisation' => $this->organisation
                ], [
            'id' => $this->id
        ]);
    }

    private function setId($id) {
        $this->id = $id;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setSurname($surname) {
        $this->surname = $surname;
    }
    
    public function setOrganisation($organisation) {
        $this->organisation = $organisation;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getSurname() {
        return $this->surname;
    }
    
    public function getOrganisation() {
        return $this->organisation;
    }

}
