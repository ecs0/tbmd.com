<!DOCTYPE html>

<?php
    include_once("php/View.php");
    include_once('php/LoginManager.php');
    $view = new View();
    $login = new LoginManager("error.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/overlay.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <script src="script/signup.js"></script>
    <script src="script/overlay.js"></script>
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
                <input type="hidden" name="return" value="../index.php">
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
                <input type="hidden" name="return" value="../index.php">
                <p>
                    <select name="movie">
                        <?php echo $view->moviesAsTag("option")?>
                    </select> (movie)
                </p>
                <p>
                    <input name="rating" type="number" min="1" max="5" step="1" value="1" required> (rating)
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
    <section class="top_bar">
        <?php echo $login->getContentButtons(); ?>
        <section class="login">
            <form method='post' action='php/login_handler.php'>
                <?php echo $login->getLoginForm(); ?>
            </form>
        </section>
    </section>
    <header>
        <div class="logo">tbmd.com</div>
        <h1>Error</h1>
    </header>
    <section class="content">
        <h1>Oops! There has been a database error!</h1>
        <p>
            <?php echo filter_input(INPUT_GET, 'error'); ?>
        </p>
        <a href="../index.php">Click here to return to the front page.</a>
    </section>
</body>
</html>
