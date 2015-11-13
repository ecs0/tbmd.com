<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('Connection.php');

$q = $_REQUEST["q"];
$hint = "";
if (isset($q)) {
    $connection = new Connection();
    $movies = $connection->searchMovies($q);
    $people = $connection->searchPeople($q);
    $hint .= implode(", ", array_merge($movies, $people));
}

echo $hint;