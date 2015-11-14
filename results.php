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
        <link rel="stylesheet" href="style/main.css">
    </head>
    <body>
        <section class="content">
            <p>
            <?php
                echo $view->displaySearchResults(filter_input(INPUT_GET, 'query'));
            ?>
            </p>
            <p>
                <a href="index.php">Back to Front</a>
            </p>
        </section>
        <footer>
            tbmd.com &copy; Tim Sayler &amp; Bryan Bergen - 2015
        </footer>
    </body>
</html>
