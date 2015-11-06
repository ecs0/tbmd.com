<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 05/11/15
 * Time: 3:03 PM
 */
class Connection {

    const HOST = 'localhost';
    const USER = 'tbmd';
    const PASSWORD = 'tbmd';
    const DATABASE = 'tbmd';

    private $link;

    /**
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
            $error = mysqli_error($this->link);
            $id = mysqli_insert_id($this->link);
            $this->disconnect();
            return $id;
        }
        return -1;
    }

    public function userExists($email) {
        $this->connect();
        $sql = "SELECT email FROM users WHERE email = '".$email."'";
        $result = mysqli_query($this->link, $sql);

        $rows = mysqli_num_rows($result);
        mysqli_free_result($result);
        $this->disconnect();
        return $rows >= 1;
    }

    public function createReview($userid, $movie_id, $rating, $review_content = NULL) {
       //TODO implement
    }

    public function addPerson($fname, $lname, $birthdate, $bio) {
        //TODO implement
    }

    public function addMovie($director_id, $title, $release_date, $image, $synopsis) {
        //TODO implement
    }

    public function getImage($movieId) {
        //TODO implement
    }

    private function connect() {
        $this->link = mysqli_connect(self::HOST, self::USER, self::PASSWORD, self::DATABASE);
        if (mysqli_connect_errno()) {
            header("Location: html/error.php?error=".mysqli_connect_error());
            exit();
        }
    }

    private function disconnect() {
        if ($this->link) {
            mysqli_close($this->link);
        }
    }
}
