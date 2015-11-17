<!DOCTYPE html>

<?php
include_once('php/MovieView.php');
include_once('php/LoginManager.php');

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id');
    $movie = new MovieView($id);
    $login = new LoginManager("movie.php?id=$id");
} else {
    header("Location: index.php");
    exit();
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $movie->getTitle()." on tbmd.com"; ?></title>
        <link rel="stylesheet" href="style/main.css">
        <link rel="stylesheet" href="style/movie.css">
        <script src="script/search.js"></script>
    </head>
    <body>
        <header>
            <a href="index.php"><div class="logo">tbmd.com</div></a>
            <h1><?php echo $movie->getTitle(); ?></h1>
            <section class="login">
                <div>
                    <form method='post' action='php/login_handler.php'>
                        <?php echo $login->getLoginForm(); ?>
                    </form>
                </div>
            </section>
            <section class="search">
                <div>
                    <p>
                        <label>Search tbmd.com:
                            <input type="text" name="query" id="query" list="search_results">
                            <datalist id="search_results"></datalist>
                            <input type="button" id="btnSearch" value="Search!">
                        </label>
                    </p>
                </div>
            </section>
            <section id="add_items">
                <?php echo $login->getContentButtons(); ?>
            </section>
        </header>
        <section class="content">
            <div>
                <?php echo $movie->getBlockView(); ?>
            </div>
            <section id="reviews">
                <div>
                    <h3><?php echo "Reviews of ".$movie->getTitle().":"; ?></h3>
                    <?php echo $movie->getReviews(); ?>
                </div>
            </section>
            <p>
                <a href="index.php">Back to Front</a>
            </p>
        </section>
        <footer>
            tbmd.com &copy; Tim Sayler &amp; Bryan Bergen - 2015
        </footer>
    </body>
</html>
