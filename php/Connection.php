<?php

include_once("Movie.php");
include_once("Person.php");
include_once("Review.php");
include_once("User.php");

/**
 * Connection Constants
 */
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
 *
 * This class interfaces with the underlying database,
 * return objects or collections of objects.
 * It should be used primarily by the controller class for formatted output
 *
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
                    "VALUES ('$email', '$username', PASSWORD('.$password.'), CURDATE())";

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

    /**
     * @param null $ids
     * @return array
     */
    public function getUsers($ids = NULL) {
        $this->connect();
        $sql = "SELECT id, email, username FROM users";

        if ($ids) {
            $sql .= " WHERE id IN (".implode(", ", $ids).")";
        }

        $result = mysqli_query($this->link, $sql);
        $users = array();
        $i = 0;
        if ($result) {

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
               $users[$i++] = new User($row['id'], $row['email'], $row['username']);
            }

            mysqli_free_result($result);
        }

        $this->disconnect();
        return $users;
    }

    /**
     * @param $userId
     * @param $movieId
     * @param $rating
     * @param $content
     * @return int|string
     */
    public function createReview($userId, $movieId, $rating, $content) {

        $this->connect();
        $content = mysqli_real_escape_string($this->link, $content);

        $sql = "INSERT INTO reviews (user_id, movie_id, submit_date, rating, review_content) ".
            "VALUES ($userId, $movieId, CURDATE(), $rating, '".$content."')";

        mysqli_query($this->link, $sql);
        $this->disconnect();
        return mysqli_insert_id($this->link);
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

            $fname = $person->getFirstName();
            $lname = $person->getLastName();
            $birthdate = $person->getBirthdate();
            $imageLink = $person->getImageLink();
            $bio = mysqli_real_escape_string($this->link, $person->getBio());

            $sql = "INSERT INTO people (fname, lname, birthdate, image_link, submit_date, bio)".
                "VALUES ('".$fname."', '".$lname."', '".$birthdate."', '".$imageLink."', ".
                "CURDATE(), '".$bio."')";

            mysqli_query($this->link, $sql);
            $id = mysqli_insert_id($this->link);
            $this->disconnect();
            return $id;
        }
        return -1;
    }

    /**
     * @param $movie
     * @return int|string
     */
    public function addMovie($movie) {
        if ($movie instanceof Movie) {
            $this->connect();

            $directorId = $movie->getDirector()->getId();
            $title = mysqli_real_escape_string($this->link, $movie->getTitle());
            $releaseDate = $movie->getReleaseDate();
            $imageLink = $movie->getImageLink();
            $synopsis = mysqli_real_escape_string($this->link, $movie->getSynopsis());


            $sql = "INSERT INTO movie (director_id, title, release_date, submit_date, image_link, synopsis)".
                "VALUES ($directorId, '".$title."', '".$releaseDate."', CURDATE(), '".$imageLink."',".
                " '".$synopsis."')";


            mysqli_query($this->link, $sql);
            $id = mysqli_insert_id($this->link);

            if ($id > 0) {

                $callback = function($person) use ($id) {
                    if ($person instanceof Person) {
                        $personId = $person->getId();
                        return "($id, $personId)";
                    } else {
                        return "";
                    }
                };

                $bridgePairs = array_map($callback, $movie->getActors());
                $values = implode(", ", $bridgePairs);

                $bridgeSql = "INSERT INTO actor (movie_id, people_id) VALUES $values";

                mysqli_query($this->link, $bridgeSql);
            }

            $this->disconnect();
            return $id;
        }
        return -1;
    }

    /**
     * @param null $ids
     * @return array
     */
    public function getMovies($ids = NULL) {
        $this->connect();
        $sql = "SELECT id, director_id, title, release_date, submit_date, image_link, synopsis FROM movie";

        if ($ids) {
            $sql .= " WHERE id IN (".implode(", ", $ids).")";
        }

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
                $actors = $this->getActors($id);

                $movie = new Movie($id, $director[0], $title, $releaseDate, $synopsis, $submitDate, $imageLink, $actors);
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
                $user = $this->getUsers([$row['user_id']]);
                $movie = $this->getMovies([$row['movie_id']]);
                $submitDate = $row['submit_date'];
                $rating = $row['rating'];
                $reviewContent = $row['review_content'];

                $review = new Review($id, $user[0], $movie[0], $submitDate, $rating, $reviewContent);
                $reviews[$i++] = $review;
            }

            mysqli_free_result($result);
        }

        $this->disconnect();
        return $reviews;
    }

    /**
     * Fetches all people who acted in a particular movie
     *
     * @param $movieId
     * @return array
     */
    public function getActors($movieId) {
        $this->connect();

        $sql = "SELECT people.id, ".
            "people.fname, ".
            "people.lname, ".
            "people.birthdate, ".
            "people.image_link, ".
            "people.submit_date, ".
            "people.bio FROM actor INNER JOIN movie ON actor.movie_id = movie.id ".
            "INNER JOIN people ON actor.people_id = people.id ".
            "WHERE movie_id = ".$movieId;

        $result = mysqli_query($this->link, $sql);
        $actors = array();
        $i = 0;
        if ($result) {

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $person = new Person($row['id'],
                    $row['fname'],
                    $row['lname'],
                    $row['birthdate'],
                    $row['image_link'],
                    $row['submit_date'],
                    $row['bio']);

                $actors[$i++] = $person;
            }

            mysqli_free_result($result);
        }

        $this->disconnect();
        return $actors;
    }

    public function getImage($movieId) {
        //TODO implement
    }

    /**
     * Opens a connection to the database using mysqli
     */
    private function connect() {
        $this->link = mysqli_connect(Constants::HOST, Constants::USER, Constants::PASSWORD, Constants::DATABASE);
        if (mysqli_connect_errno()) {
            header("Location: html/error.php?error=".mysqli_connect_error());
            exit();
        }
    }

    /**
     * Closes the mysqli database connection if it is open
     */
    private function disconnect() {
        if ($this->link != NULL) {
            mysqli_close($this->link);
            $this->link = NULL;
        }
    }
}
