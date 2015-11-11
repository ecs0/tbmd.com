<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/7/15
 * Time: 2:13 PM
 */

include_once('Connection.php');

/*
 * Ajax email validation
 */
if (isset($_REQUEST['q'])) {
    $email = $_REQUEST['q'];
    $connection = new Connection();
    if ($connection->userExists($email)) {
        echo "duplicate";
    } else {
        echo "";
    }
    exit();
}

if (isset($_POST['submit'])) {

    $email = filter_input(INPUT_POST, 'email');
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $return = filter_input(INPUT_POST, "return");

    $connection = new Connection();
    $connection->createUser($email, $username, $password);

    // if the caller forgot to set the return, we'll go back to the front page
    if (!$return) {
        $return = "../index.php";
    }

    header("Location: $return?creation=success");
} else {
    header("Location: ../index.php?creation=failed"); // temp
}

