<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/7/15
 * Time: 5:24 PM
 */

include_once('Connection.php');

if (isset($_POST['submit'])) {

    $title = filter_input(INPUT_POST, 'title');
    $releaseDate = filter_input(INPUT_POST, 'release_date');
    $directorId = filter_input(INPUT_POST, 'director');
    $actorIds = filter_input(INPUT_POST, 'actors', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $imageLink = filter_input(INPUT_POST, 'image_link');
    $synopsis = filter_input(INPUT_POST, 'synopsis');

    $connection = new Connection();

    $director = $connection->getPeople([$directorId]);
    $actors = $connection->getPeople($actorIds);

    $movie = new Movie(NULL, $director[0], $title, $releaseDate, $synopsis, NULL, $imageLink, $actors);

    $connection->addMovie($movie);

    header("Location: ../html/bryan.php?creation=success");
} else {
    header("Location: ../html/bryan.php?creation=failed");
}
