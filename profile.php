<!DOCTYPE html>

<?php
include_once("php/UserView.php");

if (isset($_GET['id'])) {
    $user = new UserView(filter_input(INPUT_GET, 'id'));
} else {
    header("Location: index.php");
    exit();
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $user->getUsername()." on tbmd.com"; ?></title>
        <link rel="stylesheet" href="style/main.css">
        <script src="script/search.js"></script>
    </head>
    <body>
        <header>
            <h1>
                <?php echo $user->getUsername();?>
            </h1>
            <section id="search">
                <div class="search_bar">
                    <p>
                        <label>Search the Site:
                            <input type="text" name="query" id="query" list="search_results">
                            <datalist id="search_results"></datalist>
                            <input type="button" id="btnSearch" value="Search!">
                        </label>
                    </p>
                </div>
            </section>
        </header>
        <section class="content">
            <p>
                <?php echo "Email: ".$user->getEmail(); ?>
            </p>
            <p>
                <?php echo "Favourite Movie: ".$user->getFavouriteMovie(); ?>
            </p>
            <p>
                <?php echo "Average Movie Rating: ".$user->getAverageRating(); ?>
            </p>
            <section>
                <h3><?php echo "Reviews made by ".$user->getUsername().":"; ?></h3>
                <?php echo $user->getUserReviews(); ?>
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
