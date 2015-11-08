<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/8/15
 * Time: 10:37 AM
 */

include_once("Connection.php");

if (isset($_POST['submit'])) {

    $movieId = filter_input(INPUT_POST, 'movie');
    $userId = filter_input(INPUT_POST, 'user');
    $rating = filter_input(INPUT_POST, 'rating');
    $content = filter_input(INPUT_POST, 'content');

    $connection = new Connection();

    $connection->createReview($userId, $movieId, $rating, $content);

    header("Location: ../html/bryan.php?creation=success");
} else {
    header("Location: ../html/bryan.php?creation=failed");
}