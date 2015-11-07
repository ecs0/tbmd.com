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

    // register add user
    //TODO this needs to also validate password strength (maybe) and check for duplicate email/usernames using ajax
    document.getElementById('btnAddUser').addEventListener("click", function() {
        overlay("add_user");
    }, false);
    document.getElementById('add_user_close').addEventListener("click", function() {
        overlay("add_user");
    }, false);
}, false);

function overlay(id) {
    var element = document.getElementById(id);
    element.style.visibility = (element.style.visibility == "visible") ? "hidden" : "visible";
}

