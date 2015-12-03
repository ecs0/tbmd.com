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
        return "http://tbmd.com/movie.php?id=" . $this->id;
    }


    /**
     * @return string
     */
    public function rssDescription() {
        return substr($this->description, 0, 60);
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
     * XMLReader. to be removed.
     * @return string
     */
    public function readRSS() {

        $final = "../rss/rss.xml";
        $x = new XMLReader();
        $temp = new DOMDocument;
        $x->open($final, "UTF-8");
//        $x->moveToAttribute("<item>");
//        $p = $x->readInnerXML();
        $p = "";

        while ($x->read() && $x->name !== 'item') {
            while ($x->name === 'item') {
                $node = simplexml_import_dom($temp->importNode($x->expand(), true));

                $p = "magic";
            }
        }

        return $p;
    }

    /**
     * Create's rss file if
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
//        $tmp = "../rss/rss_tmpl.xml";
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

    /**
     * function to create/update rss feed
     * deprecated function. to be removed.
     */
    public function addRSS() {
        $new_rss = "../rss/new.xml";
        $tmpRSS = file_get_contents("../rss/rss_tmpl.xml");
        $new = fopen($new_rss, "w");
        $final = "../rss/rss.xml";
        $body = $this->rssItem();

        fwrite($new, $tmpRSS);
        fwrite($new, $body);
        fwrite($new, $this->readRSS());
        fwrite($new, $this->rssClose());
        fclose($new);
        rename($new_rss, $final);

    }

}