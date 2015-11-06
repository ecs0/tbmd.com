<?php

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:29 PM
 */
class Person {

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
     * @param $bio
     */
    public function __construct($id, $firstName, $lastName, $birthdate, $imageLink, $bio) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthdate = $birthdate;
        $this->imageLink = $imageLink;
        $this->submitDate = NULL;
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

}