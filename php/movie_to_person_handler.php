<?php
include_once('Connection.php');


if (isset($_POST['submit'])) {
    $return = filter_input(INPUT_POST, 'return');
    $movieId = filter_input(INPUT_POST, 'movieId');
    $personId = filter_input(INPUT_POST, 'person');
    
    $connection = new Connection();
    $connection->addActorToMovie($movieId, $personId);
    
    header("Location: $return");
} else {
    header("Location: ../index.php");
}
