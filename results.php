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
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.0/notify.min.js"></script>
        <script src="script/notifications.js"></script>
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
                    <input type="hidden" name="return" value="<?php echo "$return"; ?>">
                    <p>
                        <input id="email" type="email" name="email" placeholder="Email" required>
                        <span class="warning" id="duplicate_warning"></span>
                    </p>
                    <p>
                        <input id="username" type="text" name="username" placeholder="Username" required>
                    </p>
                    <p>
                        <input id="password" type="password" name="password" placeholder="Password" required>
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
                    <input type="hidden" name="return" value="<?php echo "$return"; ?>">
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
                    <input type="hidden" name="return" value="<?php echo "$return"; ?>">
                    <p>
                        <input type="text" name="title" placeholder="Title" required>
                    </p>
                    <p>
                        <input type="date" name="release_date" required> (release date)
                    </p>
                    <p>
                        <select name="director">
                            <?php echo $view->peopleAsTag("option") ?>
                        </select> (director)
                    </p>
                    <p> 
                        <select class="actor_list" name="actors[]" multiple> 
                            <?php echo $view->peopleAsTag("option") ?>
                        </select> (actors)
                    </p> 
                    <p>
                        <input type="button" id="btnAddDirector" value="New Person">
                    </p>
                    <p>
                        <textarea cols="40" rows="10" name="synopsis" placeholder="Enter Synopsis here..." required></textarea>
                    </p>
                    <p>
                        <input type="file" name="upload" accept="image/*">
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
                    <input type="hidden" name="return" value="<?php echo "$return"; ?>">
                    <p>
                        <select name="movie">
                            <?php echo $view->moviesAsTag("option")?>
                        </select> (movie)
                    </p>
                    <p>
                        <span class="star_rating" id="new_movie_rating">
                            <input id="rating10" type="radio" name="rating" value="10">
                            <label for="rating10">10</label>
                            <input id="rating9" type="radio" name="rating" value="9">
                            <label for="rating9">9</label>
                            <input id="rating8" type="radio" name="rating" value="8">
                            <label for="rating8">8</label>
                            <input id="rating7" type="radio" name="rating" value="7">
                            <label for="rating7">7</label>
                            <input id="rating6" type="radio" name="rating" value="6">
                            <label for="rating6">6</label>
                            <input id="rating5" type="radio" name="rating" value="5">
                            <label for="rating5">5</label>
                            <input id="rating4" type="radio" name="rating" value="4">
                            <label for="rating4">4</label>
                            <input id="rating3" type="radio" name="rating" value="3">
                            <label for="rating3">3</label>
                            <input id="rating2" type="radio" name="rating" value="2">
                            <label for="rating2">2</label>
                            <input id="rating1" type="radio" name="rating" value="1">
                            <label for="rating1">1</label>
                        </span>
                    </p>
                    <p>
                        <textarea name="content" cols="40" rows="10" placeholder="Write your review here..."></textarea>
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
