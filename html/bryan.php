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

        $email = filter_input(INPUT_POST, 'email');
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        if ($link->userExists($email)) {
            echo "<h1>User already exists!</h1>";
        } else {
            $id = $link->createUser($email, $username, $password);
            echo "<h1>Thank you for signing up $username!</h1>";
            echo "<a href='../index.php'>Back to the front page.</a>";
            exit();
        }
    }
?>

    <form method="post" action="bryan.php">

        <p>
            <label>Email:
                <input name="email" type="email" max="30" maxlength="50">
            </label>
        </p>
        <p>
            <label>Username:
                <input name="username" type="text" max="30" maxlength="50">
            </label>
        </p>
        <p>
            <label>Password:
                <input name="password" type="password" max="30" maxlength="50">
            </label>
        </p>
        <p>
            <input name="submit" type="submit" value="Submit">
        </p>
    </form>
</body>
</html>