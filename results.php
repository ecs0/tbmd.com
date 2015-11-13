<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    include_once('php/View.php');
    $view = new View();
    $view->search(filter_input(INPUT_GET, 'query'));
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Search Results</title>
    </head>
    <body>
        <?php
            echo $view->displaySearchResults(filter_input(INPUT_GET, 'query'));
        ?>
    </body>
</html>
