<?php
include_once('LoginManager.php');


if (!isset($_POST['submit'])) {
    header("Location: ../index.php");
    exit();
}

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$loginManager = new LoginManager();
$loginManager->login($email, $password);
header("Location: ../index.php");




