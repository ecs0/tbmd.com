<!DOCTYPE html>

<?php
include_once('php/Connection.php');
include_once('php/Movie.php');

$connection = new Connection();
if (isset($_GET['id'])) {
    $movie = $connection->getMoviesById([filter_input(INPUT_GET, 'id')])[0];
    if ($movie instanceof Movie) {
        $title = $movie->getTitle();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo "$title on tbmd.com"; ?></title>
    </head>
    <body>
        
    </body>
</html>
