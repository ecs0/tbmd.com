<!DOCTYPE html>

<?php
    include_once("php/View.php");
    include_once('php/LoginManager.php');
    $view = new View();
    $login = new LoginManager();
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to tbmd.com</title>
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/overlay.css">
    <link rel="stylesheet" href="style/movie.css">
    <script src="script/signup.js"></script>
    <script src="script/overlay.js"></script>
    <script src="script/search.js"></script>
</head>
<body>

    <!-- Hidden Page Content -->
    <?php //<editor-fold defaultstate="collapsed" desc="Hidden Forms for Javascript Popups"> ?>
    <div class="overlay" id="add_user">
        <div>
            <input class="exit" id="add_user_close" type="button" value="x">
            <h1>Sign Up for tbmd.com!</h1>
            <form method="post" action="php/signup_handler.php">
                <input type="hidden" name="return" value="../index.php">
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
                <input type="hidden" name="return" id="../index.php">
                <p>
                    <label>
                        First Name:
                        <input type="text" name="fname" max="50" maxlength="50" required>
                    </label>
                </p>
                <p>
                    <label>
                        Last Name:
                        <input type="text" name="lname" max="50" maxlength="50" required>
                    </label>
                </p>
                <p>
                    <label>
                        Birth Date:
                        <input type="date" name="birthdate" required>
                    </label>
                </p>
                <p>
                    <label>
                        Picture:
                        <input type="file" name="upload" accept="image/*">
                    </label>
                </p>
                <p>
                    <label>
                        Biography:
                        <textarea cols="40" rows="10" name="bio" required></textarea>
                    </label>
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
                <input type="hidden" name="return" value="../index.php">
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
                <input type="hidden" name="return" value="../index.php">
                <p>
                    <label>Movie:
                        <select name="movie">
                            <?php echo $view->moviesAsTag("option")?>
                        </select>
                    </label>
                </p>
                <p>
                    <label>User:
                        <select name="user">
                            <?php echo $view->usersAsTag("option") ?>
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
        <div class="logo">tbmd.com</div>
        <h1>Welcome to tbmd.com!</h1>
        <section class="login">
            <div>
                <?php echo $login->getLoginForm(); ?>
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
        <section id="top_rated_movies">
            <h2 class="aggregate">Top Rated Movies</h2>
            <?php echo $view->highestRatedMoviesAsBlock() ;?>
        </section>
        <section id="recent_reviews">
            <h2 class="aggregate">Recent Reviews</h2>
            <?php echo $view->recentReviewsAsBlock(); ?>
        </section>
        <section id="upcoming_movies">
            <h2 class="aggregate">Upcoming Movies</h2>
            <?php echo $view->upcomingMoviesAsBlock(); ?>
        </section>
    </section>
    <footer>
        tbmd.com &copy; Tim Sayler &amp; Bryan Bergen - 2015
    </footer>
</body>
</html>