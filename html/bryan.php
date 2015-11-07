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
            <p>
                This will be in the overlay
            </p>
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