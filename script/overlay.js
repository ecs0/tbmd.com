/**
 * 'Modal' dialogs for entering user input
 * Created by bryan on 11/7/15.
 */

window.addEventListener('load', function() {

    // register add person
    registerButton(document.getElementById('btnAddPerson'), 'add_person');
    registerButton(document.getElementById('add_person_close'), 'add_person');
    registerButton(document.getElementById('btnAddDirector'),
        'add_movie', 'add_person');

    // register add user
    registerButton(document.getElementById('btnAddUser'), 'add_user');
    registerButton(document.getElementById('add_user_close'), 'add_user');

    // register add movie
    registerButton(document.getElementById('btnAddMovie'), 'add_movie');
    registerButton(document.getElementById('add_movie_close'), 'add_movie');

    // register add review
    registerButton(document.getElementById('btnAddReview'), 'add_review');
    registerButton(document.getElementById('add_review_close'), 'add_review');

}, false);

function registerButton(button, id, secondaryId) {
    if (button !== null) {
        button.addEventListener('click', function() {
            overlay(id);
            if (secondaryId !== undefined) {
                overlay(secondaryId);
            }
        }, false);
    }
}

function overlay(id) {
    var element = document.getElementById(id);
    element.style.visibility =
            (element.style.visibility === 'visible') ? 'hidden' : 'visible';
}

