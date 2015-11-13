<?php
include_once('Connection.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersonView
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
    
    public function getImage() {
        $link = $this->person->getImageLink();
        if ($link) {
            $imgSrc = "'images/uploads/".$link."'";
        } else {
            $imgSrc = "'images/person_placeholder.jpg'";
        }
        $image = "<img class='person_image' src=$imgSrc alt='".$this->person."'>";
        return $image;
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
    
    private function buildList($movies) {
        $html = "<div>";
        foreach ($movies as $movie) {
            $html .= $movie->asBlockView();
        }
        $html .= "</div>";
        
        return $html;
    }
}
