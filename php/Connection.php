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

    /**
     * @var mysqli
     */
    private $link;

    /**
     * Clean up in destructor
     */
    function __destruct() {
        $this->disconnect();
    }

    public function searchMovies($query) {
        $where = "WHERE title LIKE '%".$query."%'";
        return $this->getMovies($where);
    }
    
    public function searchPeople($query) {
        $where = "WHERE CONCAT_WS(' ', fname, lname) LIKE '%".$query."%'";
        return $this->getPeople($where);
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
                    "VALUES ('$email', '$username', PASSWORD('$password'), CURDATE())";

            mysqli_query($this->link, $sql);
            $id = mysqli_insert_id($this->link);
            $this->disconnect();
            return $id;
        }
        return -1;
    }

    /**
     * Checks an email/password combo against the database
     * 
     * @param type $email
     * @param type $password
     * @return boolean/int, false if the user doesnt exist, their id if they do
     */
    public function checkLogin($email, $password) {
        $this->connect();
        $sql = "SELECT id FROM users WHERE "
                . "email = '".$email."' "
                . "AND password = PASSWORD('".$password."')";
        $result = mysqli_query($this->link, $sql);
        
        if ($result) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $id = $row['id'];
            mysqli_free_result($result);
            $this->disconnect();
            return $id;
        } else {
            $this->disconnect();
            return FALSE;
        }
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
     * Fetches all users from the database [optionally filtered by ids]
     *
     * @param null $ids - optional filter
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
     * Insert a new review into the dataabse
     *
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
        $id = mysqli_insert_id($this->link);
        $this->disconnect();
        return $id;
    }

    /**
     * This function adds a new person to the database
     *
     * @param $person
     * @return int|string - id of the person, or -1 if the insert fails
     */
    public function addPerson($person) {

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
     * Insert a new movie in to the database, updating the actor bridge table as well
     *
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

            // update the bridge table
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

    public function addActorToMovie($movieId, $actorId) {
        $this->connect();
        
        $sql = "INSERT INTO actor (movie_id, people_id) "
                . "VALUES ($movieId, $actorId)";

        return mysqli_query($this->link, $sql);
    }
    
    
    /**
     * Fetches all movies in a list of ids from the database
     *
     * @param $ids
     * @return array
     */
    public function getMoviesById($ids) {
        return $this->getMovies("WHERE id IN (".implode(", ", $ids).")");
    }

    /**
     * Fetches all movies from the database [that match the optional parameter if given]
     *
     * @param null $where - optional WHERE clause
     * @return array
     */
    public function getMovies($where = NULL) {
        $this->connect();
        $sql = "SELECT id, director_id, title, release_date, submit_date, image_link, synopsis FROM movie ";

        if ($where) {
            $sql .= $where;
        }

        $result = mysqli_query($this->link, $sql);
        $movies = array();
        if ($result) {

            $i = 0;
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $id = $row['id'];
                $director = $this->getPeopleById([$row['director_id']]);
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
     * Returns an array of all movies that release after the current date, in ascending order (date order)
     *
     * @return array
     */
    public function getUpcomingMovies() {
        $where = "WHERE release_date > CURDATE() ORDER BY release_date ASC";
        return $this->getMovies($where);
    }

    /**
     *  Fetch all people from the data base filtered by id
     * 
     * @param type $ids - query filter
     * @return type - array of People
     */
    public function getPeopleById($ids) {
        $where = " WHERE id IN (".implode(", ", $ids).")";
        return $this->getPeople($where);
    }
    
    /**
     * Fetch all or some people from the database
     *
     * @param null $where - Optional where clause
     * @return array
     */
    public function getPeople($where = NULL) {
        $this->connect();
        $sql = "SELECT id, fname, lname, birthdate, image_link, submit_date, bio FROM people ";

        if ($where) {
            $sql .= $where;
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
     * Fetches all reviews made by a specific user
     *
     * @param $userId - the id of the user to filter reviews by
     * @return array
     */
    public function getUserReviews($userId) {
        return $this->getReviews("WHERE user_id = $userId ORDER BY submit_date DESC");
    }

    /**
     * Fetches all reviews from the database [filtered by the optional where clause]
     *
     * @param null $where - optional where clause
     * @return array
     */
    public function getReviews($where = NULL) {
        $this->connect();
        $sql = "SELECT id, user_id, movie_id, submit_date, rating, review_content FROM reviews ";

        if ($where) {
            $sql .= $where;
        }

        $result = mysqli_query($this->link, $sql);
        $reviews = array();
        $i = 0;
        if ($result) {

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $id = $row['id'];
                $user = $this->getUsers([$row['user_id']]);
                $movie = $this->getMoviesById([$row['movie_id']]);
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

    /**
     * Returns a list of all reviews sorted by date in descending order (recent first)
     *
     * @param null $movieId - optionally filter the reviews by date
     * @return array
     */
    public function getReviewsByDate($movieId = null) {
        $this->connect();
        $filter = "ORDER BY submit_date DESC ";
        $where = $movieId ? "WHERE movie_id = $movieId " : "";
        return $this->getReviews($where.$filter);
    }

    /**
     * Returns all movies sorted by their average review score (highest first).
     * Movies with no ratings are not included.
     *
     * @return array - Array of tuples (movie, rating)
     */
    public function getMoviesByReviewScore() {
        $this->connect();

        $sql = "SELECT ".
            "movie.id, ".
            "movie.director_id, ".
            "movie.title, ".
            "movie.release_date, ".
            "movie.synopsis, ".
            "movie.submit_date, ".
            "movie.image_link, ".
            "AVG(reviews.rating) average ".
            " FROM movie INNER JOIN reviews ON movie.id = reviews.movie_id ".
            "GROUP BY movie.id ORDER BY average DESC ";

        $result = mysqli_query($this->link, $sql);

        $movies = array();
        $i = 0;
        if ($result) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rating = $row['average'];
                $movieId = $row['id'];
                $movie = new Movie($movieId,
                    $this->getPeopleById([$row['director_id']])[0],
                    $row['title'],
                    $row['release_date'],
                    $row['synopsis'],
                    $row['submit_date'],
                    $row['image_link'],
                    $this->getActors($movieId));

                $movies[$i++] = array($movie, $rating);
            }
            mysqli_free_result($result);
        }
        
        $this->disconnect();
        return $movies;
    }

    public function getMoviesByDirector($directorId) {
        $where = "WHERE director_id = $directorId";
        return $this->getMovies($where);
    }
    
    public function getActorsNotIn($movieId) {
        $this->connect();
        
        $sql = "SELECT "
                . "people.id, "
                . "people.fname, "
                . "people.lname, "
                . "people.birthdate, "
                . "people.image_link, "
                . "people.submit_date, "
                . "people.bio "
                . "FROM people INNER JOIN actor "
                . "ON people.id = actor.people_id "
                . "WHERE people.id NOT IN ("
                . " SELECT actor.people_id "
                . " FROM actor "
                . " WHERE movie_id = $movieId) "
                . "GROUP BY people.id";
        
        $result = mysqli_query($this->link, $sql);
        
        $actors = array();
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
                $actors[$i++] = $person;
            }
            mysqli_free_result($result);
        }
        
        $this->disconnect();
        return $actors;
    }

    /**
     *  Fetches an array of all movies that a particular actor does not 
     *  act in (although they may direct it).
     * 
     * @param type $actorId - id of the actor to filter by
     * @return \Movie
     */
    public function getMoviesNotIn($actorId) {
        $this->connect();
        
        $sql = "SELECT "
                . "movie.id, "
                . "movie.director_id, "
                . "movie.title, "
                . "movie.release_date, "
                . "movie.synopsis, "
                . "movie.submit_date, "
                . "movie.image_link "
                . "FROM movie INNER JOIN actor "
                . "ON movie.id = actor.movie_id "
                . "WHERE movie.id NOT IN ("
                . " SELECT actor.movie_id "
                . " FROM actor "
                . " WHERE people_id = $actorId) "
                . "GROUP BY movie.id";
        
        $result = mysqli_query($this->link, $sql);
        
        $movies = array();
        $i = 0;
        if ($result) {
            
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $movieId = $row['id'];
                $movie = new Movie($movieId,
                    $this->getPeopleById([$row['director_id']])[0],
                    $row['title'],
                    $row['release_date'],
                    $row['synopsis'],
                    $row['submit_date'],
                    $row['image_link'],
                    $this->getActors($movieId));
                $movies[$i++] = $movie;
            }
            mysqli_free_result($result);
        }
        
        $this->disconnect();
        return $movies;
    }
    
    public function getMoviesByActor($actorId) {
        $this->connect();
        
        $sql = "SELECT ".
            "movie.id, ".
            "movie.director_id, ".
            "movie.title, ".
            "movie.release_date, ".
            "movie.synopsis, ".
            "movie.submit_date, ".
            "movie.image_link ".
            "FROM movie INNER JOIN actor ON actor.movie_id = movie.id ".
                "WHERE actor.people_id = $actorId";
        
        $result = mysqli_query($this->link, $sql);
        
        $movies = array();
        $i = 0;
        if ($result) {
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $movieId = $row['id'];
                $movie = new Movie($movieId,
                    $this->getPeopleById([$row['director_id']])[0],
                    $row['title'],
                    $row['release_date'],
                    $row['synopsis'],
                    $row['submit_date'],
                    $row['image_link'],
                    $this->getActors($movieId));
                $movies[$i++] = $movie;
            }
            mysqli_free_result($result);
        }
        
        $this->disconnect();
        return $movies;
    }
    
    public function getAverageRating($movieId) {
        $this->connect();
        $sql = "SELECT AVG(reviews.rating) average FROM movie ".
                "INNER JOIN reviews ON movie.id = reviews.movie_id ".
                "WHERE movie.id = $movieId";
        $result = mysqli_query($this->link, $sql);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $rating = $row['average'];
            mysqli_free_result($result);
        }
        
        $this->disconnect();
        return $rating;
    }
    
    public function getAverageUserRating($userId) {
        $this->connect();
        $sql = "SELECT AVG(rating) average FROM reviews WHERE user_id = $userId";
        $result = mysqli_query($this->link, $sql);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $average = $row['average'];
            mysqli_free_result($result);
        }
        
        $this->disconnect();
        return $average;
    }
    
    public function getFavouriteMovie($userId) {
        $this->connect();
        $sql = "SELECT ".
                "movie.id, ".
                "movie.director_id, ".
                "movie.title, ".
                "movie.release_date, ".
                "movie.synopsis, ".
                "movie.submit_date, ".
                "movie.image_link, ".
                "MAX(reviews.rating) rating ".
                "FROM movie INNER JOIN reviews ON movie.id = reviews.movie_id ".
                "INNER JOIN users ON reviews.user_id = users.id ".
                "ORDER BY reviews.submit_date DESC";
        $result = mysqli_query($this->link, $sql);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $fav = new Movie($row['id'], 
                    $row['director_id'], 
                    $row['title'], 
                    $row['release_date'], 
                    $row['synopsis'], 
                    $row['submit_date'], 
                    $row['image_link']);
            mysqli_free_result($result);
        }
        
        $this->disconnect();
        return $fav;
    }
    
    /**
     * Opens a connection to the database using mysqli
     */
    private function connect() {
        $this->link = mysqli_connect(Constants::HOST, Constants::USER, Constants::PASSWORD, Constants::DATABASE);
        if (mysqli_connect_errno()) {
            header("Location: error.php?error=".mysqli_connect_error());
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
