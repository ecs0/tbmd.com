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
    public function rssLink() {
        return "http://tbmd.com/movie.php?id=" . $this->id;
    }


    /**
     * @return string
     */
    public function rssDescription() {
        return substr($this->description, 0, 60) . "...";
    }

    /**
     * Create rss file if
     * it does not exist.
     */
    private function makeRSS() {
        $tmp = "../rss/rss_tmpl.xml";
        $final = "../rss/rss.xml";
        if (!is_file($final)) {
            copy($tmp, $final);
        }

    }

    /**
     * Creates a new RSS entry
     * in the rss feed.
     */
    public function newRSS() {
        $this->makeRSS();
        $tmpRSS = file_get_contents("../rss/rss.xml");
        $final = "../rss/rss.xml";

        $sXML = new SimpleXMLElement($tmpRSS);
        $channel = $sXML->channel[0];
        $item = $channel->addChild('item');
        $item->addChild('title', $this->title);
        $item->addChild('link', $this->rssLink());
        $item->addChild('description',$this->rssDescription());
        $item->addChild('guid', $this->rssLink());
        $sXML->asXML($final);

    }
}