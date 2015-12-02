<?php
include_once('Connection.php');


if (isset($_POST['submit'])) {
    $return = filter_input(INPUT_POST, 'return');
    $movieId = filter_input(INPUT_POST, 'movieId');
    $personId = filter_input(INPUT_POST, 'person');
    
    $connection = new Connection();
    $connection->addActorToMovie($movieId, $personId);
    
    if (strpos($return, "?") !== FALSE) {
        $notificationGets = "&quickadd=true";
    } else {
        $notificationGets = "?quickadd=true";
    }
    
    header("Location: $return$notificationGets");
} else {
    header("Location: ../index.php");
}
