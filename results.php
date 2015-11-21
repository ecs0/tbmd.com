<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    include_once('php/View.php');
    include_once('php/LoginManager.php');
    $view = new View();
    $query = filter_input(INPUT_GET, 'query');
    $view->search($query);
    $login = new LoginManager("results.php?query=$query");
    $return = "../results.php?query=$query";
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Search Results</title>
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/overlay.css">
        <script src="script/overlay.js"></script>
        <script src="script/search.js"></script>
        <script src="script/upload.js"></script>
    </head>
    <body>
        
        <!-- Hidden Page Content -->
        <?php //<editor-fold defaultstate="collapsed" desc="Hidden Forms for Javascript Popups"> ?>
        <div class="overlay" id="add_user">
            <div>
                <input class="exit" id="add_user_close" type="button" value="x">
                <h1>Sign Up for tbmd.com!</h1>
                <form method="post" action="php/signup_handler.php">
                    <input type="hidden" name="return" value=<?php echo "$return"; ?>>
                    <p>
                        <label>Email:
                            <input id="email" type="email" name="email" required>
                            <span class="warning" id="duplicate_warning"></span>
                        </label>
                    </p>
                    <p>
                        <label>Username:
                            <input id="username" type="text" name="username" required>
                        </label>
                    </p>
                    <p>
                        <label>Password:
                            <input id="password" type="password" name="password" required>
                        </label>
                    </p>
                    <p>
                        <input id="btnSubmitUser" type="submit" name="submit" value="Sign Up!">
                    </p>
                </form>
            </div>
        </div>
        <div class="overlay" id="add_person">
            <div>
                <input id="add_person_close" class="exit" type="button" value="x">
                <h1>Enter a Person</h1>
                <form method="post" action="php/person_handler.php" enctype="multipart/form-data">
                    <input type="hidden" name="return" value="../index.php">
                    <p>
                        <input type="text" name="fname" max="50" maxlength="50" placeholder="First Name" required>
                    </p>
                    <p>
                        <input type="text" name="lname" max="50" maxlength="50" placeholder="Last Name" required>
                    </p>
                    <p>
                        <input type="date" name="birthdate" required> (DOB)
                    </p>
                    <p>
                        <textarea cols="40" rows="10" name="bio" placeholder="Enter biography here..." required></textarea>
                    </p>
                    <p> 
                        <input type="file" name="upload" accept="image/*">
                    </p>
                    <p>
                        <input name="submit" type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </p>
                </form>
            </div>
        </div>
        <div class="overlay" id="add_movie">
            <div>
                <input class="exit" id="add_movie_close" type="button" value="x">
                <h1>Enter a Movie</h1>
                <form method="post" action="php/movie_handler.php" enctype="multipart/form-data">
                    <input type="hidden" name="return" value=<?php echo "$return"; ?>>
                    <p>
                        <label>Title
                            <input type="text" name="title" required>
                        </label>
                    </p>
                    <p>
                        <label>Release Date
                            <input type="date" name="release_date" required>
                        </label>
                    </p>
                    <p>
                        <label>Director
                            <select name="director">
                                <?php echo $view->peopleAsTag("option") ?>
                            </select>
                            <input type="button" id="btnAddDirector" value="New Person">
                        </label>
                    </p>
                    <p>
                        <label>Actors
                            <select name="actors[]" multiple>
                                <?php echo $view->peopleAsTag("option") ?>
                            </select>
                        </label>
                    </p>
                    <p>
                        <label>Image
                            <input type="file" name="upload" accept="image/*">
                        </label>
                    </p>
                    <p>
                        <label>Synopsis
                            <textarea cols="40" rows="10" name="synopsis" required></textarea>
                        </label>
                    </p>
                    <p>
                        <input type="submit" name="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </p>
                </form>
            </div>
        </div>
        <div class="overlay" id="add_review">
            <div>
                <input class="exit" id="add_review_close" type="button" value="x">
                <h1>Submit A Review</h1>
                <form method="post" action="php/review_handler.php">
                    <input type="hidden" name="return" value=<?php echo "$return"; ?>>
                    <p>
                        <label>Movie:
                            <select name="movie">
                                <?php echo $view->moviesAsTag("option")?>
                            </select>
                        </label>
                    </p>
                    <p>
                        <label>Rating:
                            <input name="rating" type="number" min="1" max="5" step="1" value="1" required>
                        </label>
                    </p>
                    <p>
                        <label>Review:
                            <textarea name="content" cols="40" rows="10"></textarea>
                        </label>
                    </p>
                    <p>
                        <input type="submit" name="submit" value="Submit">
                    </p>
                </form>
            </div>
        </div>
        <?php //</editor-fold>?>

        <!-- Visible Page Content -->
        <header>
            <a href="index.php"><div class="logo">tbmd.com</div></a>
            <h1>Search Results</h1>
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
            <section class="top_bar">
                <?php echo $login->getContentButtons(); ?>
                <section class="login">
                    <form method='post' action='php/login_handler.php'>
                        <?php echo $login->getLoginForm(); ?>
                    </form>
                </section>
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
