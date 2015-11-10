<?php

/**
 * Created by PhpStorm.
 * User: tsayler
 * Date: 08/11/15
 * Time: 4:52 PM
 */

class Image {
    //TODO: investigate path info. Needs to work on any system.
    const IMAGEUPLOADDIR = '/var/www/html/tbmd.com/images/uploads/';


    function __construct() {

    }


/**
 * Simple method to generate a hash
 * for file uploads.
 * Using MD5, other algorithms available.
 * @param $imageName
 * @return string containing the hash of the file.
 */
function imageHash($imageName) {
    return hash_file('MD5', $imageName);
}

function checkImageDuplicate() {
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

function uploadImage(){

        //TODO: FIX THE LOGIC!
        foreach ($_FILES as $file_name => $file_array) {

            if (is_file(Image::IMAGEUPLOADDIR.$file_array['name'])) {
                break;
            }
            if (is_uploaded_file($file_array["tmp_name"])) {
                move_uploaded_file($file_array["tmp_name"],
                    Image::IMAGEUPLOADDIR.hash_file('MD5',$file_array["name"]));

            }
        }
    }
}



