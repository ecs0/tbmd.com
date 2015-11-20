<?php

/**
 * Created by PhpStorm.
 * User: tsayler
 * Date: 11/11/15
 * Time: 8:36 AM
 * 
 * This class will manage file uploads and server side image validation
 * For each image uploaded, it will attempt to generate a unique id to avoid
 * file name collisions.
 */
class Uploader {

    private $file;
    
    /**
     * Instantiate an Uploader with a single element from $_FILES
     * 
     * @param type $file
     */
    public function __construct($file) {
        $this->file = $file;
    }

    /**
     * Uploads the file contents to the webserver and returns the unique
     * file name, including extension
     * 
     * @return boolean|string
     */
    public function upload() {
        
        $base_dir = $_SERVER['DOCUMENT_ROOT']."/images/uploads/";
        
        // create unique file name
        $name = $this->file['name'];
        
        if ($name == "") {
            return FALSE;
        }
        
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $hashed_name =  md5($name + uniqid(time())).".".$extension;
        
        // check if file actually an image
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $this->file['tmp_name']);
        if (!strstr($mime, "image")) {
            return FALSE;
        }
        finfo_close($finfo);
        
        // make dir if needed
        if (!is_dir($base_dir)) {
            mkdir($base_dir);
        }
        
        // finally upload
        if (is_uploaded_file($this->file['tmp_name']) && 
                move_uploaded_file($this->file['tmp_name'], $base_dir.$hashed_name)) {
            return $hashed_name;
        }
        
        return FALSE;
    }
}