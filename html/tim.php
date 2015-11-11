<!DOCTYPE html>

<h1>File upload testing page</h1>
<?php
    require_once '../php/Uploader.php';

    if (!empty($_FILES['image'])) {

        $upload = Uploader::factory('uploads/images');
        $upload->file($_FILES['image']);
        $result = $upload->upload();
        var_dump($result);

    }
?>
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

