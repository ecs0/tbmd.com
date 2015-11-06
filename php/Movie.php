<?php

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:29 PM
 */
class Movie {

    private $id;
    private $directorId;
    private $title;
    private $releaseDate;
    private $submissionDate;
    private $synopsis;


    /**
     * Movie constructor.
     * @param $id
     * @param $directorId
     * @param $title
     * @param $releaseDate
     * @param $synopsis
     */
    public function __construct($id, $directorId, $title, $releaseDate, $synopsis) {
        $this->id = $id;
        $this->directorId = $directorId;
        $this->title = $title;
        $this->releaseDate = $releaseDate;
        $this->submissionDate = NULL;
        $this->synopsis = $synopsis;
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
}