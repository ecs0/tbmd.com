<?php

include_once("User.php");
include_once("Movie.php");
include_once("LoginManager.php");

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

        $movie = $this->getMovie();
        $title = $movie->getTitle();
        $movieId = $movie->getId();
        $link = "movie.php?id=$movieId";
        $a = "<a href='".$link."' target='_blank'>$title</a>";
        $header = "<h3>$a</h3>"; 
        
        $login = new LoginManager("../error.php");
        
        $userId = $this->user->getId();
        if ($login->isLoggedIn() && $userId == $login->getLoggedInUserId()) {
            $addReview = "<input class='edit_review' id='edit_".$this->id."' type='button' value='Edit'>";
        } else {
            $addReview = "";
        }
        
        
        $userLink = "profile.php?id=".$this->getUser()->getId();
        $userA = "<a href='".$userLink."' target='_blank'>$this->user</a>";
        $submission = "<p><strong>Submitted By: </strong>$userA</p>"; 
        $date = "<p><strong>Submitted On: </strong>$this->submitDate</p>";
        $rating = "<p><strong>Rating: </strong><span class='rating'>$this->rating</span>/5 Stars</p>";
        $review = "<p><strong>Review: </strong><span class='review_content'>$this->reviewContent</span></p>";
        $id = "'".$this->id."'";
        
        return "<div id=$id class='review_block'>$addReview$header$submission$date$rating$review</div>";
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