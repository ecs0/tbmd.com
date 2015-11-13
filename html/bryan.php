<!DOCTYPE html>

<?php
    include("../php/View.php");
    $view = new View();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bryan's Test Page</title>
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/overlay.css">
    <script src="../script/overlay.js"></script>
    <script src="../script/signup.js"></script>
</head>
<body>

    <div class="overlay" id="add_review">
        <div>
            <input class="exit" id="add_review_close" type="button" value="x">
            <h1>Submit A Review</h1>
            <form method="post" action="../php/review_handler.php">

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

    <div class="overlay" id="add_movie">
        <div>
            <input class="exit" id="add_movie_close" type="button" value="x">
            <h1>Enter a Movie</h1>
            <form method="post" action="../php/movie_handler.php" enctype="multipart/form-data">

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
    <div class="overlay" id="add_user">
        <div>
            <input class="exit" id="add_user_close" type="button" value="x">
            <h1>Sign up for tbmd.com!</h1>
            <form method="post" action="../php/signup_handler.php">
                <input type="hidden" name="return" value="../html/bryan.php">
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
            <form method="post" action="../php/person_handler.php" enctype="multipart/form-data">
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
    <!--
        Currently this page will basically dump the contents out onto the page for testing purposes
    -->
    <form action="#" method="post">
        <p>
            <label>Movies:
                <select>
                    <option>Select a Movie:</option>
                    <?php echo $view->moviesAsTag("option"); ?>
                </select>
            </label>
            <label>People:
                <select>
                    <option>Select a Person:</option>
                    <?php echo $view->peopleAsTag("option"); ?>
                </select>
            </label>
            <label>Reviews:
                <select>
                    <option>Select a Review:</option>
                    <?php echo $view->reviewsAsTag("option"); ?>
                </select>
            </label>
            <label>Users:
                <select>
                    <option>Select a User:</option>
                    <?php echo $view->usersAsTag("option"); ?>
                </select>
            </label>
        </p>
        <p>
            <!-- search bars -->
            <label>Search for a Movie:
                <input type="text" name="search_movie" list="movies">
                <datalist id="movies">
                    <?php echo $view->moviesAsTag("option", true); ?>
                </datalist>
            </label>
            <label>Search for a Person:
                <input type="text" name="search_person" list="people">
                <datalist id="people">
                    <?php echo $view->peopleAsTag("option", true); ?>
                </datalist>
            </label>
        </p>
    </form>

    <div>
        <input type="button" id="btnAddUser" value="Sign Up">
        <input type="button" id="btnAddPerson" value="Add Person">
        <input type="button" id="btnAddMovie" value="Add Movie">
        <input type="button" id="btnAddReview" value="Add Review">
    </div>

    <table class="fixed" id="movies">
        <caption>Movies</caption>
        <?php echo $view->moviesAsTable(); ?>
    </table>
    <hr>
    <table class="fixed">
        <caption>Upcoming Movies</caption>
        <?php echo $view->moviesAsTable(true); ?>
    </table>
    <hr>
    <table class="fixed" id="people">
        <caption>People</caption>
        <?php echo $view->peopleAsTable(); ?>
    </table>
    <hr>
    <table class="fixed" id="reviews">
        <caption>Reviews</caption>
        <?php echo $view->reviewsAsTable(); ?>
    </table>
    <hr>
    <table class="fixed" id="users">
        <caption>Users</caption>
        <?php echo $view->usersAsTable(); ?>
    </table>
    <hr>
    <table class="fixed">
        <caption>Highest Rated Movies</caption>
        <?php echo $view->ratedMoviesAsTable(); ?>
    </table>
</body>
</html>