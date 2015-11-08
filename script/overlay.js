/**
 * 'Modal' dialogs for entering user input
 * Created by bryan on 11/7/15.
 */

window.addEventListener("load", function() {

    // register add person
    document.getElementById("btnAddPerson").addEventListener("click", function() {
        overlay("add_person");
    }, false);
    document.getElementById("add_person_close").addEventListener("click", function() {
        overlay("add_person");
    }, false);
    document.getElementById("btnAddDirector").addEventListener("click", function() {
        overlay('add_movie');
        overlay('add_person');
    }, false);

    // register add user
    document.getElementById('btnAddUser').addEventListener("click", function() {
        overlay("add_user");
    }, false);
    document.getElementById('add_user_close').addEventListener("click", function() {
        overlay("add_user");
    }, false);

    // register add movie
    document.getElementById('btnAddMovie').addEventListener("click", function() {
        overlay('add_movie');
    }, false);
    document.getElementById('add_movie_close').addEventListener('click', function() {
        overlay('add_movie');
    }, false);

}, false);

function overlay(id) {
    var element = document.getElementById(id);
    element.style.visibility = (element.style.visibility == "visible") ? "hidden" : "visible";
}

