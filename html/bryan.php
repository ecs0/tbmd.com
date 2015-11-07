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
        <?php echo $controller->moviesAsTable() ?>
    </table>
    <hr>
    <table class="fixed" id="people">
        <?php echo $controller->peopleAsTable() ?>
    </table>
    <hr>
    <table class="fixed" id="reviews">
        <?php echo $controller->reviewsAsTable() ?>
    </table>
    <hr>
    <table class="fized" id="users">
        <?php echo $controller->usersAsTable() ?>
    </table>

</body>
</html>