<?php
include_once("Connection.php");
include_once('User.php');

/**
 * Description of UserView
 *
 * @author bryan
 */
class UserView {
    
    private $user;
    
    public function __construct($userId) {
        $connection = new Connection();
        $this->user = $connection->getUsers([$userId])[0];
        if (!($this->user instanceof User)) {
            header("Location: ../index.php");
            exit();
        }
    }
    
    public function getUsername() {
        return (string)  $this->user;
    }
    
    public function getEmail() {
        return $this->user->getEmail();
    }
    
    public function getUserReviews() {
        $connection = new Connection();
        $reviews = $connection->getUserReviews($this->user->getId());
        $html = "";
        foreach($reviews as $review) {
            $html .= $review->asBlockView();
        }
        return $html;
    }
    
    public function getAverageRating() {
        $connection = new Connection();
        $average = $connection->getAverageUserRating($this->user->getId());
        
        if ($average) {
            return number_format($average, 2);
        } else {
            return "This user has not rated any movies yet.";
        }
    }
    
    public function getFavouriteMovie() {
        $connection = new Connection();
        $fav = $connection->getFavouriteMovie($this->user->getId());
        
        if ($fav) {
            $link = "'movie.php?id=".$fav->getId()."'";
            $title = $fav->getTitle();
            $a = "<a href=$link target='_blank'>$title</a>";
        } else {
            $a = "This user has not rated any movies yet.";
        }
        return $a;
    }
}
