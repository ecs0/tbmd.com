<?php

/**
 * Created by PhpStorm.
 * User: tsayler
 * Date: 30/11/15
 * Time: 10:00 AM
 */

class RSS {
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $title;
    /**
     * @var
     */
    private $link;
    /**
     * @var
     */
    private $description;
    /**
     * @var
     */
    private $guid;


    /**
     * RSS constructor.
     * @param $id
     * @param $title
     * @param $link
     * @param $description
     */
    function __construct($id, $title, $link, $description) {
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link) {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getGuid() {
        return $this->guid;
    }

    /**
     * @param mixed $guid
     */
    public function setGuid($guid) {
        $this->guid = $guid;
    }


    /**
     * @return string
     */
    public function rssItem() {
        $item = "<item>";
        $item .= $this->rssTitle() . $this->rssLink() . $this->rssDescription() .
             $this->rssGUID();
        $item .= "</item>";
        //. $this->rssCategory($category);
        return $item;

    }

    /**
     * @return string
     */
    public function rssTitle() {
        return "<title>" . $this->title . "</title>";
    }

    /*
     * @param $link the ID of the movie or person
     */
    /**
     * @return string
     */
    public function rssLink() {
        return "<link>" . "http://tbmd.com/movie.php?id=" . $this->id . "</link>";
    }


    /**
     * @return string
     */
    public function rssDescription() {
        return "<description>" . substr($this->description, 0, 60) . "</description>";
    }

    /**
     * @return string
     */
    public function rssGUID(){
        return "<guid isPermaLink=\"true\">" . "http://tbmd.com/movie.php?id=" . $this->id . "</guid>";
    }

    /**
     * @return string
     */
    public function rssClose() {
        return "</channel></rss>";
    }

    /**
     *
     */
    public function addRSS() {
        $new_rss = "../rss/new.xml";
        $tmpRSS = file_get_contents("../rss/rss_tmpl.xml");
        $new = fopen($new_rss, "w");
        $final = "../rss/rss.xml";
        $body = $this->rssItem();

        fwrite($new, $tmpRSS);
        fwrite($new, $body);
        fwrite($new, $this->rssClose());
        fclose($new);
        rename($new_rss, $final);

    }

}