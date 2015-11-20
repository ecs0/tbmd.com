<?php
include_once('Connection.php');

/**
 * This class manages the dynamic display of the person.php page
 *
 * @author bryan
 */
class PersonView {

    private $person;
    
    public function __construct($id) {
        $connection = new Connection();
        $this->person = $connection->getPeopleById([$id])[0];
        if (!($this->person instanceof Person)) {
            // other wise there would be no content to display
            header("Location: ../index.php");
            exit();
        }
    }
    
    public function getName() {
        return (string)$this->person;
    }
    
    public function getTitle() {
        return $this->person." on tbmd.com";
    }
    
    public function getMoviesAsActor() {
        //TODO check for no entries, and insert a different output
        $connection = new Connection();
        $movies = $connection->getMoviesByActor($this->person->getId());
        return $this->buildList($movies);
    }
    
    public function getMoviesAsDirector() {
        //TODO check for no entries, and insert a different output
        $connection = new Connection();
        $movies = $connection->getMoviesByDirector($this->person->getId());
        return $this->buildList($movies);
    }
    
    public function getBlockView() {
        return $this->person->asBlockView();
    }
    
    private function buildList($movies) {
        $html = "<div>";
        foreach ($movies as $movie) {
            $html .= $movie->asBlockView();
        }
        $html .= "</div>";
        
        return $html;
    }
}
