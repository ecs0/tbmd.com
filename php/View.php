<?php

include_once("Connection.php");

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/6/15
 * Time: 1:49 PM
 *
 * This class interfaces with the database layer,
 * converting data into html segments to be displayed on the page
 *
 */
class View {

    public function moviesAsTable() {
        $innerHtml = "<thead><tr>".
            "<th>id</th><th>director</th><th>title</th><th>release date</th><th>synopsis</th>".
            "<th>submitted</th><th>image</th><th>Actors</th>".
            "</tr></thead>";

        $link = new Connection();

        $body = "";
        foreach ($link->getMovies() as $movie) {
            if ($movie instanceof Movie) {
                $body .= $movie->asTableRow();
            }
        }

        $innerHtml .= "<tbody>$body</tbody>";
        return $innerHtml;
    }

    public function moviesAsTag($tag) {
        $innerHtml = "";
        $link = new Connection();

        foreach ($link->getMovies() as $movie) {
            if ($movie instanceof Movie) {
                $innerHtml .= $this->tag($tag, $movie);
            }
        }

        return $innerHtml;
    }

    public function peopleAsTable() {
        $innerHtml = "<thead><tr>".
            "<th>id</th><th>first name</th><th>last name</th><th>birthdate</th><th>image</th><th>submitted</th><th>bio</th>".
            "</tr></thead>";

        $link = new Connection();

        $body = "";
        foreach ($link->getPeople() as $person) {
            if ($person instanceof Person) {
                $body .= $person->asTableRow();
            }
        }

        $innerHtml .= "<tbody>$body</tbody>";
        return $innerHtml;
    }

    public function peopleAsTag($tag) {
        $innerHtml = "";
        $link = new Connection();

        foreach ($link->getPeople() as $person) {
            if ($person instanceof Person) {
                $innerHtml .= $this->tag($tag, $person);
            }
        }

        return $innerHtml;
    }

    public function reviewsAsTable() {
        $innerHtml = "<thead><tr>".
            "<th>id</th><th>user</th><th>movie</th><th>submit date</th><th>rating</th><th>content</th>".
            "</tr></thead>";

        $link = new Connection();
        $body = "";
        foreach ($link->getReviews() as $review) {
            if ($review instanceof Review) {
                $body .= $review->asTableRow();
            }
        }

        $innerHtml .= "<tbody>$body</tbody>";
        return $innerHtml;
    }

    public function reviewsAsTag($tag) {
        $innerHtml = "";
        $link = new Connection();

        foreach ($link->getReviews() as $review) {
            if ($review instanceof Review) {
                $innerHtml .= $this->tag($tag, $review);
            }
        }
        return $innerHtml;
    }

    public function usersAsTable() {
        $innerhtml = "<thead><tr>".
            "<th>Email</th><th>Username</th>".
            "<tr></thead>";

        $link = new Connection();
        $body = "";
        foreach ($link->getUsers() as $user) {
            if ($user instanceof User) {
                $body .= $user->asTableRow();
            }
        }

        $innerhtml .= "<tbody>$body</tbody>";
        return $innerhtml;
    }

    public function usersAsTag($tag) {
        $innerHtml = "";
        $link = new Connection();

        foreach ($link->getUsers() as $user) {
            if ($user instanceof User) {
                $innerHtml .= $this->tag($tag, $user);
            }
        }
        return $innerHtml;
    }

    /**
     * Marks up a domain object
     *
     * @param $start - the opening tag, e.g. 'option', 'a' or 'a href="index.html"'
     * @param $content - the object to be marked up, if it has an id, it will be used as a value attribute
     * @param null $end - closing tag, if different than start, e.g if you wanted to include an attribute like href
     * @return string - a fully marked up domain object based on it's string representation
     */
    public function tag($start, $content, $end = NULL) {
        if ($end == NULL) {
            $end = $start;
        }

        $element = "<$start";
        if (method_exists($content, "getId")) {
            $element .= " value='".$content->getId()."'";
        }
        $element .= ">$content</$end>";

        return $element;
    }
}