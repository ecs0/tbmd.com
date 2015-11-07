<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/7/15
 * Time: 12:17 PM
 */

include_once('Connection.php');
include_once('Person.php');

//TODO eventually check for an auth session token or cookie

if (!isset($_POST['submit'])) {
    header("Location: ../html/bryan.php");
    exit();
}

//TODO upload image file and save it to the image repo

$fname = filter_input(INPUT_POST, 'fname');
$lname = filter_input(INPUT_POST, 'lname');
$birthdate = filter_input(INPUT_POST, 'birthdate');
$image_link = filter_input(INPUT_POST, 'image_link');
$bio = filter_input(INPUT_POST, 'bio');

$connection = new Connection();
$person = new Person(NULL, $fname, $lname, $birthdate, $image_link, NULL, $bio);

$connection->addPerson($person);

header("Location: ../html/bryan.php");

