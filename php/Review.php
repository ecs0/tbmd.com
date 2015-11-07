<?php

include_once("User.php");
include_once("Movie.php");

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:29 PM
 */
class Review extends stdClass {

    private $id;
    private $user;
    private $movie;
    private $submitDate;
    private $rating;
    private $reviewContent;

    /**
     * Review constructor.
     * @param $id
     * @param $user
     * @param $movie
     * @param $submitDate
     * @param $rating
     * @param $reviewContent
     */
    function __construct($id, $user, $movie, $submitDate, $rating, $reviewContent) {
        $this->id = $id;
        $this->user = $user;
        $this->movie = $movie;
        $this->submitDate = $submitDate;
        $this->rating = $rating;
        $this->reviewContent = $reviewContent;
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
    public function getUser() {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getMovie() {
        return $this->movie;
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
    public function getRating() {
        return $this->rating;
    }

    /**
     * @return mixed
     */
    public function getReviewContent() {
        return $this->reviewContent;
    }

    public function asTableRow() {
        $username = $this->getUser()->getUserName();
        $movieTitle = $this->getMovie()->getTitle();
        return "<tr><td>$this->id</td><td>$username</td><td>$movieTitle</td>".
        "<td>$this->submitDate</td><td>$this->rating</td><td>$this->reviewContent</td></tr>";
    }

    public function asSelect() {
        $username = $this->getUser()->getUserName();
        $movieTitle = $this->getMovie()->getTitle();
        return "<option>$movieTitle, $this->rating star(s) by: $username</option>";
    }

}