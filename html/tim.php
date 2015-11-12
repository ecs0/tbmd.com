<!DOCTYPE html>

<h1>File upload testing page</h1>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <form enctype="multipart/form-data" method="post" action="">
        <input type="file" name="image">
        <input type="submit" name="Submit" value="upload">
    </form>
    <div><img src="<?php ?>"> </div>
</body>
</html>

