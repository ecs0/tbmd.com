<?php

include_once("Person.php");

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:29 PM
 */
class Movie extends stdClass {

    private $id;
    private $director;
    private $title;
    private $releaseDate;
    private $submissionDate;
    private $synopsis;
    private $imageLink;
    private $actors;

    /**
     * Movie constructor.
     * @param $id
     * @param $director
     * @param $title
     * @param $releaseDate
     * @param $synopsis
     * @param $submissionDate
     * @param $imageLink
     * @param $actors
     */
    function __construct($id, $director, $title, $releaseDate, $synopsis, $submissionDate, $imageLink, $actors = []) {
        $this->id = $id;
        $this->director = $director;
        $this->title = $title;
        $this->releaseDate = $releaseDate;
        $this->submissionDate = $submissionDate;
        $this->synopsis = $synopsis;
        $this->imageLink = $imageLink;
        $this->actors = $actors;
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
    public function getDirector() {
        return $this->director;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate() {
        return $this->releaseDate;
    }

    /**
     * @return mixed
     */
    public function getSubmissionDate() {
        return $this->submissionDate;
    }

    /**
     * @return mixed
     */
    public function getSynopsis() {
        return $this->synopsis;
    }

    /**
     * @return mixed
     */
    public function getImageLink() {
        return $this->imageLink;
    }

    /**
     * @return array
     */
    public function getActors() {
        return $this->actors;
    }

    public function asTableRow($rating = null) {
        $director = $this->getDirector()->getFirstName()." ".$this->getDirector()->getLastName();
        $actorNames = array_map(function($person) {
            if ($person instanceof Person) {
                return $person->getFirstName()." ".$person->getLastName();
            } else {
                return "";
            }
        }, $this->actors);
        $actorString = implode(", ", $actorNames);
        $row = "<tr><td>$this->id</td><td>$director</td><td>$this->title</td><td>$this->releaseDate</td>".
        "<td>$this->synopsis</td><td>$this->submissionDate</td><td>$this->imageLink</td>".
        "<td>$actorString</td>";

        if ($rating != null) {
            $row .= "<td>$rating</td>";
        }

        return $row."</tr>";
    }

    public function asBlockView() {

        if (!$this->imageLink) {
            $imgSrc = "'images/movie_placeholder.jpg'";
        } else {
            $imgSrc = "'images/uploads/$this->imageLink"."'";
        }
        
        $link = "movie.php?id=$this->id";
        $a = "<a href='".$link."' target='_blank'>$this->title</a>";
        
        $title = "<h2>$a</h2>";
        $img = "<img class='movie_image' src=$imgSrc alt='".$this->title."'";
        $release = "<p><strong>Release Date: </strong>$this->releaseDate</p>";
        
        $directorId = $this->director->getId();
        $directorLink = "'person.php?id=$directorId"."'";
        $directerAnchor = "<a href=$directorLink target='_blank'>$this->director</a>";
        $director = "<p><strong>Directed By: </strong>$directerAnchor</p>";
        
        $actorList = array();
        $i = 0;
        foreach ($this->actors as $actor) {
            $id = $actor->getId();
            $link = "'person.php?id=$id"."'";
            $a = "<li><a href=$link target='_blank'>$actor</a></li>";
            $actorList[$i++] = $a;
        }
        
        $actors = "<p><strong>Starring: </strong><ul>".implode("", $actorList)."</ul></p>";
        $synopsis = "<p><strong>Synopsis: </strong>$this->synopsis</p>";
        $id = "'".$this->id."'";
        
        //TODO add a 'review this movie' link
        
        return "<div id=$id class='movie_block'>$title$img$release$director$actors$synopsis</div>";
    }
    
    public function __toString() {
        return "$this->title";
    }
}