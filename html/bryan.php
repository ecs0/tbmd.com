<!DOCTYPE html>

<?php
    include("../php/Controller.php");
    $controller = new Controller();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bryan's Test Page</title>
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>

    <!--
        Currently this page will basically dump the contents out onto the page for testing purposes
    -->
    <form action="#" method="post">
        <p>
            <label>Movies:
                <select>
                    <?php echo $controller->moviesAsDropDown() ?>
                </select>
            </label>
            <label>People:
                <select>
                    <?php echo $controller->peopleAsDropDown() ?>
                </select>
            </label>
            <label>Reviews:
                <select>
                    <?php echo $controller->reviewsAsDropDown() ?>
                </select>
            </label>
            <label>Users:
                <select>
                    <?php echo $controller->usersAsDropDown() ?>
                </select>
            </label>
        </p>
    </form>

    <table class="fixed" id="movies">
        <caption>Movies</caption>
        <?php echo $controller->moviesAsTable() ?>
    </table>
    <hr>
    <table class="fixed" id="people">
        <caption>People</caption>
        <?php echo $controller->peopleAsTable() ?>
    </table>
    <hr>
    <table class="fixed" id="reviews">
        <caption>Reviews</caption>
        <?php echo $controller->reviewsAsTable() ?>
    </table>
    <hr>
    <table class="fized" id="users">
        <caption>Users</caption>
        <?php echo $controller->usersAsTable() ?>
    </table>

</body>
</html>