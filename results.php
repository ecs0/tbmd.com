<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    include_once('php/View.php');
    include_once('php/LoginManager.php');
    $login = new LoginManager("results.php");
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
        <header>
            <a href="index.php"><div class="logo">tbmd.com</div></a>
            <h1>Search Results</h1>
            <section class="login">
                <div>
                    <form method='post' action='php/login_handler.php'>
                        <?php echo $login->getLoginForm(); ?>
                    </form>
                </div>
            </section>
            <section class="search">
                <div>
                    <p>
                        <label>Search tbmd.com:
                            <input type="text" name="query" id="query" list="search_results">
                            <datalist id="search_results"></datalist>
                            <input type="button" id="btnSearch" value="Search!">
                        </label>
                    </p>
                </div>
            </section>
            <section id="add_items">
                <p>
                    <input type="button" id="btnAddPerson" value="Add an Actor or Director!">
                    <input type="button" id="btnAddMovie" value="Add a Movie!">
                    <input type="button" id="btnAddReview" value="Review your Favourite Movie!">
                </p>
            </section>
        </header>
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
