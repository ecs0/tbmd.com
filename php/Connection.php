<?php

include_once("Movie.php");
include_once("Person.php");
include_once("Review.php");
include_once("User.php");

class Constants {
    const HOST = 'localhost';
    const USER = 'tbmd';
    const PASSWORD = 'tbmd';
    const DATABASE = 'tbmd';
}

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:03 PM
 */
class Connection {

    private $link;

    function __destruct() {
        $this->disconnect();
    }

    /**
     * Saves a new user to the database, will check to see if the user already exists
     *
     * @param $email
     * @param $username
     * @param $password
     * @return int - Id of the newly created user, -1 if the user already exists
     */
    public function createUser($email, $username, $password) {

        if (!$this->userExists($email)) {
            $this->connect();

            $sql = "INSERT INTO users (email, username, password, join_date) ".
                    "VALUES ('$email', '$username', PASSWORD($password), CURDATE())";

            mysqli_query($this->link, $sql);
            $id = mysqli_insert_id($this->link);
            $this->disconnect();
            return $id;
        }
        return -1;
    }

    /**
     * Checks to see if a user already exists in the database, returning true if they do
     *
     * @param $email
     * @return bool
     */
    public function userExists($email) {
        $this->connect();
        $sql = "SELECT email FROM users WHERE email = '".$email."'";
        $result = mysqli_query($this->link, $sql);

        $rows = mysqli_num_rows($result);
        mysqli_free_result($result);
        $this->disconnect();
        return $rows >= 1;
    }

    public function getUsers($ids = NULL) {
        $this->connect();
        $sql = "SELECT email, username FROM users";

        if ($ids) {
            $sql .= " WHERE id IN (".implode(", ", $ids).")";
        }

        $result = mysqli_query($this->link, $sql);
        $users = array();
        $i = 0;
        if ($result) {

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
               $users[$i++] = new User($row['email'], $row['username']);
            }

            mysqli_free_result($result);
        }

        $this->disconnect();
        return $users;
    }

    /**
     * Enters a new review into the database
     *
     * @param $review
     * @return int|string - id of the review, or -1 if the insert fails
     */
    public function createReview($review) {

        //TODO test
        if ($review instanceof Review) {
            $this->connect();

            $sql = "INSERT INTO reviews (user_id, movie_id, submit_date, rating, review_content) ".
                "VALUES ($review->getUserId(), $review->getMovieId(), CURDATE(), $review->getRating(), ".
                "'$review->getReviewContent()' )";

            mysqli_query($this->link, $sql);
            $id = mysqli_insert_id($this->link);
            $this->disconnect();
            return $id;
        }
        return -1;
    }

    /**
     * This function adds a new person to the database
     *
     * @param $person
     * @return int|string - id of the person, or -1 if the insert fails
     */
    public function addPerson($person) {

        //TODO test and fix dates
        if ($person instanceof Person) {
            $this->connect();

            $sql = "INSERT INTO people (fname, lname, birthdate, image_link, submit_date, bio)".
                "VALUES ('$person->getFirstName()', '$person->getLastName()', CURDATE(), '$person->getImageLink()', ".
                "CURDATE(), '$person->getBio()')";

            mysqli_query($this->link, $sql);
            $id = mysqli_insert_id($this->link);
            $this->disconnect();
            return $id;
        }
        return -1;
    }

    public function addMovie($movie) {
        //TODO test and fix dates
        if ($movie instanceof Movie) {
            $this->connect();

            $sql = "INSERT INTO movie (director_id, title, release_date, submit_date, image_link, synopsis)".
                "VALUES ($movie->getDirectorId(), '$movie->getTitle()', CURDATE(), CURDATE(), '$movie->getImageLink()',".
                " '$movie->getSynopsis()')";

            mysqli_query($this->link, $sql);
            $id = mysqli_insert_id($this->link);
            $this->disconnect();
            return $id;
        }
        return -1;
    }

    /**
     * Fetches all movies from the database
     *
     * @return array
     */
    public function getMovies() {
        $this->connect();
        $sql = "SELECT id, director_id, title, release_date, submit_date, image_link, synopsis FROM movie";
        $result = mysqli_query($this->link, $sql);
        $movies = array();
        if ($result) {

            $i = 0;
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $id = $row['id'];
                $director = $this->getPeople([$row['director_id']]);
                $title = $row['title'];
                $releaseDate = $row['release_date'];
                $submitDate = $row['submit_date'];
                $imageLink = $row['image_link'];
                $synopsis = $row['synopsis'];

                $movie = new Movie($id, $director[0], $title, $releaseDate, $synopsis, $submitDate, $imageLink);
                $movies[$i++] = $movie;
            }
            mysqli_free_result($result);
        }
        $this->disconnect();
        return $movies;
    }

    /**
     * Fetch all or some people from the database
     *
     * @param null $ids - Optional where clause
     * @return array
     */
    public function getPeople($ids = NULL) {
        $this->connect();
        $sql = "SELECT id, fname, lname, birthdate, image_link, submit_date, bio FROM people";

        if ($ids) {
            $sql .= " WHERE id IN (".implode(", ", $ids).")";
        }

        $result = mysqli_query($this->link, $sql);
        $people = array();
        $i = 0;
        if ($result) {

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $id = $row['id'];
                $firstName = $row['fname'];
                $lastName = $row['lname'];
                $birthdate = $row['birthdate'];
                $imageLink = $row['image_link'];
                $submitDate = $row['submit_date'];
                $bio = $row['bio'];

                $person = new Person($id, $firstName, $lastName, $birthdate, $imageLink, $submitDate, $bio);
                $people[$i++] = $person;
            }
            mysqli_free_result($result);
        }

        $this->disconnect();
        return $people;
    }

    /**
     * Fetches all reviews from the database
     *
     * @return array
     */
    public function getReviews() {
        $this->connect();
        $sql = "SELECT id, user_id, movie_id, submit_date, rating, review_content FROM reviews";
        $result = mysqli_query($this->link, $sql);
        $reviews = array();
        $i = 0;
        if ($result) {

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $id = $row['id'];
                $userId = $row['user_id'];
                $movieId = $row['movie_id'];
                $submitDate = $row['submit_date'];
                $rating = $row['rating'];
                $reviewContent = $row['review_content'];

                $review = new Review($id, $userId, $movieId, $submitDate, $rating, $reviewContent);
                $reviews[$i++] = $review;
            }

            mysqli_free_result($result);
        }

        $this->disconnect();
        return $reviews;
    }

    public function getImage($movieId) {
        //TODO implement
    }

    private function connect() {
        $this->link = mysqli_connect(Constants::HOST, Constants::USER, Constants::PASSWORD, Constants::DATABASE);
        if (mysqli_connect_errno()) {
            header("Location: html/error.php?error=".mysqli_connect_error());
            exit();
        }
    }

    private function disconnect() {
        if ($this->link != NULL) {
            mysqli_close($this->link);
            $this->link = NULL;
        }
    }
}