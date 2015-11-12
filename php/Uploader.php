<?php

/**
 * Created by PhpStorm.
 * User: tsayler
 * Date: 11/11/15
 * Time: 8:36 AM
 */

define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']."/images/uploads/");

class Uploader {

    private $file;
    
    public function __construct($file) {
        $this->file = $file;
    }

    public function upload() {
        
        // create unique file name
        $name = $this->file['name'];
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $hashed_name =  md5($name + uniqid(time())).".".$extension;
        
        // make dir if needed
        if (!is_dir(BASE_DIR)) {
            mkdir(BASE_DIR);
        }
        
        // upload
        if (is_uploaded_file($this->file['tmp_name']) && 
                move_uploaded_file($this->file['tmp_name'], BASE_DIR.$hashed_name)) {
            return $hashed_name;
        }
        
        return FALSE;
    }
}