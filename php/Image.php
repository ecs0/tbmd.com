<?php

/**
 * Created by PhpStorm.
 * User: tsayler
 * Date: 08/11/15
 * Time: 4:52 PM
 */
class Image
{

}


$imageUploadDir = '/var/www/html/tbmd.com/images/uploads';
$allowedExtensions = array('gif','jpg','jpeg','png');

if (!is_dir($imageUploadDir)) {
    mkdir($imageUploadDir, 0755);
    //create a new group and add apache user
    //and any other (ftp...) user to the group
    //755 seems to be the acceptable permissions
    //where uploading is involved.
    //TODO: investigate permissions further.
}
/**
 * Simple method to generate a hash
 * for file uploads.
 * Using MD5, other algorithms available.
 * @param $imageName
 * @return a string containing the hash of the file.
 */
function imageHash($imageName) {
    return hash_file('MD5', $imageName);
}

function imageCrop ($imageName) {

}

/**
 * Function to check if the image name is
 * longer than 255 chars.
 * @param $imageName
 * @return bool
 */
function checkImageNameLength ($imageName){
    return ((mb_strlen($imageName, "UTF-8") > 255) ? true : false);
}

/**
 * Function to check if the image name is
 * using allowed chars.
 * @param $imageName
 * @return bool
 */
function checkImageName($imageName) {
   return ((preg_match("`^[-0-9A-Z_\.]+$`i", $imageName)) ? true : false);
}

function checkImageDuplicate ($imageName) {
    //TODO: implement
}



