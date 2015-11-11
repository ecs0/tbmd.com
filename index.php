<!DOCTYPE html>

<?php
    include("php/View.php");
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to imdb.com</title>
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/overlay.css">
    <script src="script/signup.js"></script>
    <script src="script/overlay.js"></script>
</head>
<body>

    <!-- Hidden Page Content -->
    <div class="overlay" id="add_user">
        <div>
            <input class="exit" id="add_user_close" type="button" value="x">
            <h1>Sign Up for tbmd.com!</h1>
            <form method="post" action="php/signup_handler.php">
                <input type="hidden" name="return" value="../index.php">
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

    <!-- Visible Page Content -->
    <header>
        <h1>Welcome to tbmd.com!</h1>
        <section id="login">
            <div id="login">
                <form method="post" action="#">
                    <p>
                        <label>Email:
                            <input type="email" name="email" required>
                        </label>
                    </p>
                    <p>
                        <label>Password:
                            <input type="password" name="password" required>
                        </label>
                    </p>
                    <p>
                        <input type="submit" name="submit" value="Login">
                        <input type="button" id="btnAddUser" value="Sign Up">
                    </p>
                </form>
            </div>
        </section>
    </header>
    <section id="add_items"></section>
    <section id="top_rated_movies"></section>
    <section id="recent_reviews"></section>
    <section id="upcoming_movies"></section>
    <footer>
        tbmd.com &copy; Tim Sayler &amp; Bryan Bergen - 2015
        <!-- Remove below once testing is complete -->
        <br>
        <a href="html/tim.html">Tim's Test Page</a>
        &nbsp;|&nbsp;
        <a href="html/bryan.php">Bryan's Test Page</a>
    </footer>
</body>
</html>