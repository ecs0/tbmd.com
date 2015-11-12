<?php

/**
 * Created by PhpStorm.
 * User: tsayler
 * Date: 11/11/15
 * Time: 8:36 AM
 */

//TODO: add the file extension.
class Uploader {

    private $default_permissions = 750;
    private $files_post = array();
    private $destination;
    private $tmp_name;
    private $filename;
    private $root;
    public $file = array();

    /**
     * Return upload object
     * $destination		= 'path/to/destination/folder';
     * @param string $destination
     * @param bool $root
     * @return Uploader
     * I had to rely on help from the web, and as such, I thought
     * it would be best to use the factory for use in other classes.
     */
    public static function factory($destination, $root = false) {
        return new Uploader($destination, $root);
    }

    /**
     *  Define ROOT constant, set & create destination path
     * @param string $destination
     * @param bool $root
     */
    public function __construct($destination, $root = false) {
        if ($root) {
            $this->root = $root;
        } else {
            $this->root = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR;
        }
        // set & create destination path
        if (!$this->setDestination($destination)) {
            //ERROR
        }
    }

    /**
     * Set target filename
     * @param string $filename
     */
    private function setFilename($filename) {
        $this->filename = $filename;
    }

    /**
     * upload file
     */
    public function upload() {
        $this->save();
        return $this->file['full_path'];
    }

    /**
     * Save file on server
     */
    private function save() {
        $this->saveFile();
        return $this->getState();
    }

    /**
     * Get current state data
     */
    private function getState() {
        return $this->file;
    }

    /**
     * Save file to destination
     * directory
     */
    private function saveFile() {
        //create & set new filename
        if(empty($this->filename)){
            $this->newFilename();
        }
        //set filename
        $this->file['filename']	= $this->filename;
        //set full path
        $this->file['full_path'] = $this->root . $this->destination . $this->filename;
        $this->file['path'] = $this->destination . $this->filename;
        $status = move_uploaded_file($this->tmp_name, $this->file['full_path']);
        //checks whether upload successful
        if (!$status) {
          //error handling
        }
        //done
        $this->file['status'] = true;
    }

    /**
     * Set data attributes
     */
    protected function setFileData() {
        $file_size = $this->getFileSize();
        $this->file = array(
            'status'				=> false,
            'destination'			=> $this->destination,
            'size_in_bytes'			=> $file_size,
            'original_filename'		=> $this->files_post['name'],
            'tmp_name'				=> $this->files_post['tmp_name'],
            'post_data'				=> $this->files_post,
        );
    }

    /**
     * Set File array to object
     * @param array $file
     */
    public function file($file) {
        $this->setFileArray($file);
    }

    /**
     * Set file array
     * @param array $file
     */
    private function setFileArray($file) {
        //set file data
        $this->files_post = $file;
        //set tmp path
        $this->tmp_name  = $file['tmp_name'];
    }

    /**
     * Get file size
     * @return int
     */
    private function getFileSize() {
        return filesize($this->tmp_name);
    }

    /**
     * Set destination path (return TRUE on success)
     * @param string $destination
     * @return bool
     */
    private function setDestination($destination) {
        $this->destination = $destination . DIRECTORY_SEPARATOR;
        return $this->destinationExist() ? TRUE : $this->createDestination();
    }

    /**
     * Check if destination folder exists
     * @return bool
     */
    private function destinationExist() {
        return is_writable($this->root . $this->destination);
    }

    /**
     * Create destination dir
     * @return bool
     */
    private function createDestination() {
        return mkdir($this->root . $this->destination, $this->default_permissions, true);
    }

    /**
     * Set filename to sha1 hash
     * @return string
     */
    private function newFilename() {
        $filename = sha1(mt_rand(0, 9999) . $this->destination . uniqid(time()));
        $this->setFilename($filename);
    }
}