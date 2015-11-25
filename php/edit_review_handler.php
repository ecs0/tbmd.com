<?php
include_once("Connection.php");

$return = "../index.php";

if (isset($_POST['submit'])) {
 
    $return = filter_input(INPUT_POST, "return");
    $reviewId = filter_input(INPUT_POST, "reviewId");
    $rating = filter_input(INPUT_POST, 'rating');
    $content = filter_input(INPUT_POST, 'content');
    $userId = filter_input(INPUT_POST, "userId");

    $con = new Connection();
    $con->updateReview($userId, $reviewId, $rating, $content);
}

header("Location: $return");
