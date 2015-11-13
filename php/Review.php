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

    public function asBlockView() {

        $title = $this->getMovie()->getTitle();
        $header = "<h3>$title</h3>"; //TODO convert to link
        $submission = "<p><strong>Submitted By: </strong>$this->user</p>"; //TODO convert to link to user page
        $date = "<p><strong>Submitted On: </strong>$this->submitDate</p>";
        $rating = "<p><strong>Rating: </strong>$this->rating/5 Stars</p>";
        $review = "<p><strong>Review: </strong>$this->reviewContent</p>";
        $id = "'".$this->id."'";
        
        return "<div id=$id class='review_block'>$header$submission$date$rating$review</div>";
    }
    
    public function asTableRow() {
        $username = $this->getUser()->getUserName();
        $movieTitle = $this->getMovie()->getTitle();
        return "<tr><td>$this->id</td><td>$username</td><td>$movieTitle</td>".
        "<td>$this->submitDate</td><td>$this->rating</td><td>$this->reviewContent</td></tr>";
    }

    public function __toString() {
        $username = $this->getUser()->getUserName();
        $movieTitle = $this->getMovie()->getTitle();
        return "$movieTitle, $this->rating star(s) by: $username";
    }

}