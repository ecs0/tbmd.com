<?php
include_once("Connection.php");
include_once("Person.php");


if (isset($_POST['submit'])) {
    $return = filter_input(INPUT_POST, "return");
    $id = filter_input(INPUT_POST, "personId");
    $fname = filter_input(INPUT_POST, "fname");
    $lname = filter_input(INPUT_POST, "lname");
    $bdate = filter_input(INPUT_POST, "birthdate");
    $bio = filter_input(INPUT_POST, "bio");
    
    $person = new Person($id, $fname, $lname, $bdate, NULL, NULL, $bio);
    $connection = new Connection();
    $connection->updatePerson($person);
    
    $return .= "&addentity=$fname $lname&edited=true";
}

header("Location: $return");