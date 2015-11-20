<?php
include_once('Connection.php');
include_once('Movie.php');
include_once('View.php');

/**
 * Description of MovieView
 *
 * @author bryan
 */
class MovieView extends View {

    private $movie;
    
    public function __construct($movieId) {
        $connection = new Connection();
        $this->movie = $connection->getMoviesById([$movieId])[0];
        if (!($this->movie instanceof Movie)) {
            header("Location: ../index.php");
            exit();
        }
    }
    
    public function getReviews() {
        $connection = new Connection();
        $reviews = $connection->getReviewsByDate($this->movie->getId());
        $html = "";
        foreach ($reviews as $review) {
            $html .= $review->asBlockView();
        }
        return $html;
    }
    
    public function getBlockView() {
        return $this->movie->asBlockView(true);
    }
    
    public function getTitle() {
        return $this->movie->getTitle();
    }
}
