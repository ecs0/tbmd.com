<?php

define(HOST, "localhost");
define(USER, "tbmd");
define(PASSWORD, "tbmd");
define(DATABASE, "tbmd");


/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:03 PM
 */
class Connection
{
    private $link;

    function __construct() {
        //TODO implement
    }

    public function createUser($email, $username, $password) {
        //TODO implement
        // return the id of the new user
    }

    public function userExists($email) {
       //TODO implement
    }

    public function createReview($userid, $movie_id, $rating, $review_content = NULL) {
       //TODO implement
    }

    public function addPerson($fname, $lname, $birthdate, $bio) {
        //TODO implement
    }

    public function addMovie($director_id, $title, $release_date, $image, $synopsis) {
        //TODO implement
    }

    public function getImage($movieId) {
        //TODO implement
    }

    private function connect() {
        $this->link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    }

    private function disconnect() {
        if ($this->link) {
            mysqli_close($this->link);
        }
    }
}
