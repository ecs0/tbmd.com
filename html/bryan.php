<!DOCTYPE html>

<?php include("../php/Connection.php") ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bryan's Test Page</title>
</head>
<body>
<?php
    if (isset($_POST['submit'])) {
        $link = new Connection();

    }
?>

    <form method="post" action="bryan.php">

        <p>
            <input type="submit" value="Submit">
        </p>
    </form>
</body>
</html>