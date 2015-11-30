<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/8/15
 * Time: 10:37 AM
 */

include_once("Connection.php");
include_once("LoginManager.php");

if (isset($_POST['submit'])) {

    $movieId = filter_input(INPUT_POST, 'movie');
    $rating = filter_input(INPUT_POST, 'rating');
    $content = filter_input(INPUT_POST, 'content');
    $return = filter_input(INPUT_POST, 'return');

    $login = new LoginManager($return);
    $userId = $login->getLoggedInUserId();
    
    $connection = new Connection();

    $connection->createReview($userId, $movieId, $rating, $content);

    if (!$return) {
        $return = "../index.php";
    }

    $movie = $connection->getMoviesById([$movieId])[0];
    $title = $movie->getTitle();
    
    if (strpos($return, "?") !== FALSE) {
        $notificationGets = "&addreview=$title";
    } else {
        $notificationGets = "?addreview=$title";
    }
    
    header("Location: $return$notificationGets");
} else {
    header("Location: ../index.php");
}