<?php

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:29 PM
 */
class Movie extends stdClass {

    private $id;
    private $directorId;
    private $title;
    private $releaseDate;
    private $submissionDate;
    private $synopsis;
    private $imageLink;


    /**
     * Movie constructor.
     * @param $id
     * @param $directorId
     * @param $title
     * @param $releaseDate
     * @param $synopsis
     * @param $submissionDate
     * @param $imageLink
     */
    function __construct($id, $directorId, $title, $releaseDate, $synopsis, $submissionDate, $imageLink) {
        $this->id = $id;
        $this->directorId = $directorId;
        $this->title = $title;
        $this->releaseDate = $releaseDate;
        $this->submissionDate = $submissionDate;
        $this->synopsis = $synopsis;
        $this->imageLink = $imageLink;
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
    public function getDirectorId() {
        return $this->directorId;
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

    public function asTableRow() {
        return "<tr><td>$this->id</td><td>$this->directorId</td><td>$this->title</td><td>$this->releaseDate</td>".
        "<td>$this->synopsis</td><td>$this->submissionDate</td><td>$this->imageLink</td></tr>";
    }

    public function asSelect() {
        return "<option>$this->title</option>";

    }
}