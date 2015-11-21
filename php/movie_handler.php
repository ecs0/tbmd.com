<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/7/15
 * Time: 5:24 PM
 */

include_once('Connection.php');
include_once('Uploader.php');

if (isset($_POST['submit'])) {

    $title = filter_input(INPUT_POST, 'title');
    $releaseDate = filter_input(INPUT_POST, 'release_date');
    $directorId = filter_input(INPUT_POST, 'director');
    $actorIds = filter_input(INPUT_POST, 'actors', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $synopsis = filter_input(INPUT_POST, 'synopsis');
    $return = filter_input(INPUT_POST, 'return');

    $file = $_FILES['upload'];
    $uploader = new Uploader($file);
    $imageLink = $uploader->upload();
    
    $connection = new Connection();

    $director = $connection->getPeopleById([$directorId]);
    $actors = $connection->getPeopleById($actorIds);

    $view = new Movie(NULL, $director[0], $title, $releaseDate, $synopsis, NULL, $imageLink, $actors);

    $connection->addMovie($view);

    if (!$return) {
        $return = "../index.php";
    }

    header("Location: $return");
} else {
    header("Location: ../index.php");
}
