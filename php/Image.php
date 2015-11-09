<?php

/**
 * Created by PhpStorm.
 * User: tsayler
 * Date: 08/11/15
 * Time: 4:52 PM
 */

class Image
{
    const IMAGEUPLOADDIR = '/var/www/html/tbmd.com/images/uploads/';

}

function __construct () {

}


$allowedExtensions = array('gif','jpg','jpeg','png');

if (!is_dir(Image::IMAGEUPLOADDIR)) {
    mkdir(Image::IMAGEUPLOADDIR, 0755);
    //create a new group and add apache user
    //and any other (ftp...) user to the group
    //755 seems to be the acceptable permissions
    //where uploading is involved.
    //TODO: investigate permissions further.
}

function getImage($imageName) {
    return Image::IMAGEUPLOADDIR.$imageName;
    //TODO: implement
}

/**
 * Simple method to generate a hash
 * for file uploads.
 * Using MD5, other algorithms available.
 * @param $imageName original name of the uploaded file.
 * @return a string containing the hash of the file.
 */
function imageHash($imageName) {
    return hash_file('MD5', $imageName);
}

function imageCrop ($imageName)
{
    //TODO: implement
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

/**
 * Check the image size against a predetermined value.
 * @param $imageName
 * @return bool
 */
function checkImageSize($imageName) {
    return ((filesize($imageName) > 100000) ? true : false);
    //TODO: determine max value for uploads.
}

function checkMimeType() {
    //TODO: implement
}

function uploadImage() {

    //TODO: FIX THE LOGIC!
    foreach($_FILES as $file_name => $file_array) {

        if (is_file(Image::IMAGEUPLOADDIR.$file_array['name'])) {
            break;
        }
        if (is_uploaded_file($file_array["tmp_name"])) {
            move_uploaded_file($file_array["tmp_name"],
                Image::IMAGEUPLOADDIR.imageHash($file_array["name"])) or die ("Meow");

        }
    }
}



