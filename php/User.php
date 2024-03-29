<?php

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/6/15
 * Time: 6:48 PM
 */
class User {

    private $id;
    private $email;
    private $username;

    function __construct($id, $email, $username) {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    public function asTableRow() {
        return "<tr><td>$this->email</td><td>$this->username</td></tr>";
    }

    public function __toString() {
        return $this->username;
    }
}