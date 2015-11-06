<?php

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:29 PM
 */
class Person extends stdClass {

    private $id;
    private $firstName;
    private $lastName;
    private $birthdate;
    private $imageLink;
    private $submitDate;
    private $bio;

    /**
     * Person constructor.
     * @param $id
     * @param $firstName
     * @param $lastName
     * @param $birthdate
     * @param $imageLink
     * @param $submitDate
     * @param $bio
     */
    function __construct($id, $firstName, $lastName, $birthdate, $imageLink, $submitDate, $bio) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthdate = $birthdate;
        $this->imageLink = $imageLink;
        $this->submitDate = $submitDate;
        $this->bio = $bio;
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
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getBirthdate() {
        return $this->birthdate;
    }

    /**
     * @return mixed
     */
    public function getImageLink() {
        return $this->imageLink;
    }

    /**
     * @return mixed
     */
    public function getSubmitDate() {
        return $this->submitDate;
    }

    /**
     * @return mixed
     */
    public function getBio() {
        return $this->bio;
    }

    public function asTableRow() {
        return "<tr><td>$this->id</td><td>$this->firstName</td><td>$this->lastName</td>".
            "<td>$this->birthdate</td><td>$this->imageLink</td><td>$this->submitDate</td>".
            "<td>$this->bio</td></tr>";
    }

    public function asSelect() {
        return "<option>$this->firstName $this->lastName</option>";
    }
}