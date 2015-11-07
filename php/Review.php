<?php

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:29 PM
 */
class Review extends stdClass {

    private $id;
    private $userId;
    private $movieId;
    private $submitDate;
    private $rating;
    private $reviewContent;

    /**
     * Review constructor.
     * @param $id
     * @param $userId
     * @param $movieId
     * @param $submitDate
     * @param $rating
     * @param $reviewContent
     */
    function __construct($id, $userId, $movieId, $submitDate, $rating, $reviewContent) {
        $this->id = $id;
        $this->userId = $userId;
        $this->movieId = $movieId;
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
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getMovieId() {
        return $this->movieId;
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
        return "<tr><td>$this->id</td><td>$this->userId</td><td>$this->movieId</td>".
        "<td>$this->submitDate</td><td>$this->rating</td><td>$this->reviewContent</td></tr>";
    }

    public function asSelect() {
        return "<option>$this->movieId, $this->rating by: $this->userId</option>";
    }

}