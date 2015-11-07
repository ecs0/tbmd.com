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
</head>
<body>

    <div class="overlay" id="overlay">
        <div>
            <input id="add_person_close" class="exit" type="button" value="x">
            <h1>Enter a Person</h1>
            <form method="post" action="../php/person_handler.php">
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
                        <input type="file" name="image_link">
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
                    <?php echo $view->moviesAsTag("option"); ?>
                </select>
            </label>
            <label>People:
                <select>
                    <?php echo $view->peopleAsTag("option"); ?>
                </select>
            </label>
            <label>Reviews:
                <select>
                    <?php echo $view->reviewsAsTag("option"); ?>
                </select>
            </label>
            <label>Users:
                <select>
                    <?php echo $view->usersAsTag("option"); ?>
                </select>
            </label>
        </p>
    </form>

    <div>
        <input type="button" id="add_user" value="Sign Up">
        <input type="button" id="add_person" value="Add Person">
        <input type="button" id="add_movie" value="Add Movie">
        <input type="button" id="add_review" value="Add Review">
    </div>

    <table class="fixed" id="movies">
        <caption>Movies</caption>
        <?php echo $view->moviesAsTable(); ?>
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
    <table class="fized" id="users">
        <caption>Users</caption>
        <?php echo $view->usersAsTable(); ?>
    </table>

    <div>
        <ul>
            <?php echo $view->moviesAsTag("li"); ?>
        </ul>
        <ul>
            <?php echo $view->peopleAsTag("li"); ?>
        </ul>
        <ul>
            <?php echo $view->reviewsAsTag("li"); ?>
        </ul>
        <ul>
            <?php echo $view->usersAsTag("li"); ?>
        </ul>
    </div>

</body>
</html>