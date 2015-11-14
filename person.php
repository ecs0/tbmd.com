<!DOCTYPE html>

<?php
include_once('php/PersonView.php');

if (isset($_GET['id'])) {
    $person = new PersonView(filter_input(INPUT_GET, 'id'));
} else {
    header("Location: index.php");
    exit();
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $person->getTitle(); ?></title>
        <link rel="stylesheet" href="style/main.css">
        <script src="script/search.js"></script>
    </head>
    <body>
        <header>
            <a href="index.php"><div class="logo">tbmd.com</div></a>
            <h1>
                <?php echo $person->getName();?>
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
            <div>
                <?php echo $person->getImage(); ?>
            </div>
            <div>
                <h3><?php echo "Movies Directed by ".$person->getName().":"; ?></h3>
                <?php echo $person->getMoviesAsDirector(); ?>
            </div>
            <div>
                <h3><?php echo "Movies Starring ".$person->getName().":" ?></h3>
                <?php echo $person->getMoviesAsActor(); ?>
            </div>
            <p>
                <a href="index.php">Back to Front</a>
            </p>
        </section>>
        <footer>
            tbmd.com &copy; Tim Sayler &amp; Bryan Bergen - 2015
        </footer>
    </body>
</html>
