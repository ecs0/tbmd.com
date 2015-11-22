<?php

$dir = "../images/uploads/";
$result = array();

foreach (scandir($dir) as $image) {
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, "../images/uploads/".$image);
    if (strstr($mime, "image")) {
        $result[] = $dir.$image;
    }
}

$jsonResult = json_encode($result);
echo $jsonResult;


