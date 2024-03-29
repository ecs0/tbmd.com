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

    public function asBlockView() {
        if ($this->imageLink) {
            $imgSrc = "'images/uploads/".$this->imageLink."'";
        } else {
            $imgSrc = "'images/person_placeholder.jpg'";
        }
        $image = "<img class='person_image' src=$imgSrc alt='".$this."'>";
        $name = "<b><span id='fname'>$this->firstName</span> <span id='lname'>$this->lastName</span></b>";
        $bdate = "<p><b>Birthdate: </b><span id='person_bdate'>$this->birthdate</span></p>";
        $bio = "<p><b>Bio: </b><span id='person_bio'>$this->bio</span</p>";
        
        
        $div = "$image"
                . "<div class='person_name'>$name</div>"
                . "<div class='person_bdate'>$bdate</div>"
                . "<div class='person_bio'>$bio</div>";
        return "<div id='".$this->id."' class='person_block'>$div</div>";
    }
    
    public function asTableRow() {
        return "<tr><td>$this->id</td><td>$this->firstName</td><td>$this->lastName</td>".
            "<td>$this->birthdate</td><td>$this->imageLink</td><td>$this->submitDate</td>".
            "<td>$this->bio</td></tr>";
    }

    public function __toString() {
        return "$this->firstName $this->lastName";
    }
}