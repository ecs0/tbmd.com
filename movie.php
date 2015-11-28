<!DOCTYPE html>

<?php
include_once('php/MovieView.php');
include_once('php/LoginManager.php');

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id');
    $view = new MovieView($id);
    $login = new LoginManager("movie.php?id=$id");
    $return = "../movie.php?id=$id";
} else {
    header("Location: index.php");
    exit();
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $view->getTitle()." on tbmd.com"; ?></title>
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/movie.css">
        <link rel="stylesheet" href="style/overlay.css">
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
        <script src="script/search.js"></script>
        <script src="script/overlay.js"></script>
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
                        <span class="star_rating">
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
        <div class='overlay' id='movie_to_actor' >
            <div>
                <input class="exit" id="movie_to_actor_close" type="button" value="x">
                <form method="post" action="php/movie_to_person_handler.php">
                    <input type="hidden" name="movieId" value="<?php echo $id?>">
                    <input type="hidden" name="return" value=<?php echo "$return"; ?>>
                    <h1><?php echo "Add a new actor to ".$view->getTitle(); ?></h1>
                    <p>
                        <select name="person">
                            <?php echo $view->getActorsNotIn(); ?>
                        </select>
                    </p>
                    <p>
                        <input type="submit" name="submit" value="Add">
                    </p>
                </form>
            </div>
        </div>
        <div class="overlay" id="edit_review">
            <div>
                <input class="exit" id="edit_review_close" type="button" value="x">
                <h1 id="review_title">Edit Your Review</h1>
                <form method="post" action="php/edit_review_handler.php">
                    <input type="hidden" name="userId" value="<?php echo $login->getLoggedInUserId(); ?>">
                    <input type="hidden" name="reviewId" id="reviewId" value="">
                    <input type="hidden" name="return" value="<?php echo $return; ?>">
                    <p>
                        <input id="review_form_rating" name="rating" type="number" step="1" min="1" max="5" value="1" required>
                    </p>
                    <p>
                        <textarea id="review_form_content" name="content" cols="40" rows="10" placeholder="Write your review here..."></textarea>
                    </p>
                    <p>
                        <input type="submit" name="submit" value="Update">
                    </p>
                </form>
            </div>
        </div>
        <div class="overlay" id="edit_movie">
            <div>
                <input class="exit" id="edit_movie_close" type="button" value="x">
                <h1>Edit <?php echo $view->getTitle(); ?></h1>
                <form method="post" action="php/edit_movie_handler.php">
                    <input type="hidden" name="movieId" value="<?php echo $id; ?>">
                    <input type="hidden" name="return" value="<?php echo $return; ?>">
                    <p>
                        <input type="text" id="editTitle" name="title" placeholder="Title" required>
                    </p>
                    <p>
                        <input type="date" id="releaseDate" name="release_date" required> (release date)
                    </p>
                    <p>
                        <select name="director" id="directorList">
                            <?php echo $view->peopleAsTag("option") ?>
                        </select> (director)
                    </p>
                    <p> 
                        <select class="actor_list" name="actors[]" id="actorList" multiple> 
                            <?php echo $view->peopleAsTag("option") ?>
                        </select> (actors)
                    </p> 
                    <p>
                        <textarea id="editSynopsis" cols="40" rows="10" name="synopsis" placeholder="Enter Synopsis here..." required></textarea>
                    </p>
                    <p>
                        <input type="submit" name="submit" value="Update">
                    </p>
                </form>
            </div>
        </div>
        <?php //</editor-fold>?>

        <!-- Visible Page Content -->
        <header>
            <a href="index.php"><div class="logo">tbmd.com</div></a>
            <h1><?php echo $view->getTitle(); ?></h1>
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
            <div>
                <?php echo $view->getBlockView(); ?>
            </div>
            <section id="reviews">
                <div>
                    <h3><?php echo "Reviews of <span id='movieTitle'>".$view->getTitle()."</span>:"; ?></h3>
                    <?php echo $view->getReviews(); ?>
                </div>
            </section>
            <p>
                <a href="index.php">Back to Front</a>
            </p>
        </section>
        <footer>
            tbmd.com &copy; Tim Sayler &amp; Bryan Bergen - 2015
        </footer>
    </body>
</html>
