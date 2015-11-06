<?php

include("Connection.php");

/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 11/6/15
 * Time: 1:49 PM
 */
class Controller {

    public function moviesAsTable() {
        $innerHtml = "<thead><tr>".
            "<th>id</th><th>director</th><th>title</th><th>release date</th><th>synopsis</th><th>submitted</th><th>image</th>".
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

    public function moviesAsDropDown() {
        $innerHtml = "";
        $link = new Connection();

        foreach ($link->getMovies() as $movie) {
            if ($movie instanceof Movie) {
                $innerHtml .= $movie->asSelect();
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

    public function peopleAsDropDown() {
        $innerHtml = "";
        $link = new Connection();

        foreach ($link->getPeople() as $person) {
            if ($person instanceof Person) {
                $innerHtml .= $person->asSelect();
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

    public function reviewsAsDropDown() {
        $innerHtml = "";
        $link = new Connection();

        foreach ($link->getReviews() as $review) {
            if ($review instanceof Review) {
                $innerHtml .= $review->asSelect();
            }
        }
        return $innerHtml;
    }

}