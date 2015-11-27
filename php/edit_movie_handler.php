<?php

if (isset($_POST["submit"])) {
    
    $movieId = filter_input(INPUT_POST, "movieId");
    $title = filter_input(INPUT_POST, 'title');
    $releaseDate = filter_input(INPUT_POST, 'release_date');
    $directorId = filter_input(INPUT_POST, 'director');
    $actorIds = filter_input(INPUT_POST, 'actors', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $synopsis = filter_input(INPUT_POST, 'synopsis');
    $return = filter_input(INPUT_POST, 'return');
    
    
    echo "$movieId, $title, $releaseDate, $directorId, $actorIds, $synopsis, $return";
}



