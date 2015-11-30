<?php
include_once('LoginManager.php');


if (!isset($_POST['submit'])) {
    header("Location: ../index.php");
    exit();
}
$source = filter_input(INPUT_POST, 'source');
$loginManager = new LoginManager($source);

if (!isset($_POST['email'])) {
    $loginManager->logout();
    header("Location: ../$source");
    exit();
} else {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $loginManager->login($email, $password);
}

if (strpos($source, "?") !== FALSE) {
    $notificationGets = "&signin=".$loginManager->getLoggedInUserName();
} else {
    $notificationGets = "?signin=".$loginManager->getLoggedInUserName();
}

header("Location: ../$source$notificationGets");
