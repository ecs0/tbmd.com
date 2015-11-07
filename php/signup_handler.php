<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/7/15
 * Time: 2:13 PM
 */

include_once('Connection.php');

//TODO we need to validate unique emails and/or usernames, preferably using ajax

if (isset($_POST['submit'])) {

    $email = filter_input(INPUT_POST, 'email');
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    $connection = new Connection();
    $connection->createUser($email, $username, $password);
    header("Location: ../html/bryan.php?creation=success");
} else {
    header("Location: ../html/bryan.php?creation=failed"); // temp
}

