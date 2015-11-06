<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
</head>
<body>
    <h1>Oops! There has been a database error!</h1>
    <p>
        <?php echo filter_input(INPUT_GET, 'error'); ?>
    </p>
    <a href="../index.php">Click here to return to the front page.</a>
</body>
</html>
