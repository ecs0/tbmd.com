<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/7/15
 * Time: 12:17 PM
 */

include_once('Connection.php');
include_once('Person.php');
include_once('Uploader.php');

//TODO eventually check for an auth session token or cookie

if (!isset($_POST['submit'])) {
    header("Location: ../index.php");
    exit();
}

//TODO upload image file and save it to the image repo

$fname = filter_input(INPUT_POST, 'fname');
$lname = filter_input(INPUT_POST, 'lname');
$birthdate = filter_input(INPUT_POST, 'birthdate');
$bio = filter_input(INPUT_POST, 'bio');
$return = filter_input(INPUT_POST, 'return');

$file = $_FILES['upload'];
$uploader = new Uploader($file);
$image_link = $uploader->upload();

$connection = new Connection();
$person = new Person(NULL, $fname, $lname, $birthdate, $image_link, NULL, $bio);

$connection->addPerson($person);

if (!$return) {
    $return = "../index.php";
}

header("Location: $return");

