<?php
include_once('LoginManager.php');


if (!isset($_POST['submit'])) {
    header("Location: ../index.php");
    exit();
}
$loginManager = new LoginManager();
$source = filter_input(INPUT_POST, 'source');

if (!isset($_POST['email'])) {
    $loginManager->logout();
} else {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $loginManager->login($email, $password);
}

header("Location: ../$source");




