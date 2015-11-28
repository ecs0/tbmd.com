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
    btnReview = document.getElementById("btnAddReview");
    registerButton(btnReview, 'add_review');
    registerButton(document.getElementById('add_review_close'), 'add_review');
    if (btnReview !== null) {
        btnReview.addEventListener("click", function() {
            setRating("new_movie_rating", 0);
        }, false);
    }
    
    // register quick add buttons
    registerButton(document.getElementById('btnAddActorToMovie'), 'actor_to_movie');
    registerButton(document.getElementById('actor_to_movie_close'), 'actor_to_movie');
    registerButton(document.getElementById('btnAddMovieToActor'), 'movie_to_actor');
    registerButton(document.getElementById('movie_to_actor_close'), 'movie_to_actor');

    //register person edit buttons
    var editPerson = document.getElementById("btnEditPerson");
    registerButton(editPerson, "edit_person");
    registerButton(document.getElementById("edit_person_close"), "edit_person");
    if (editPerson !== null) {
        editPerson.addEventListener("click", function () {
            fillEditPerson();
        }, false);
    }

    // register movie edit buttons
    var editMovie = document.getElementById("btnEditMovie");
    registerButton(editMovie, "edit_movie");
    registerButton(document.getElementById("edit_movie_close"), "edit_movie");
    if (editMovie !== null) {
        editMovie.addEventListener("click", function() {
            fillEditMovie();
        }, false);
    }

    // register review edit button
    registerButton(document.getElementById('edit_review_close'), 'edit_review');
    var buttons = document.getElementsByClassName("edit_review");
    for (var i = 0; i < buttons.length; i++) {
        registerButton(buttons[i], 'edit_review');
        (function(btn, id) {
            btn.addEventListener("click", function() {
                fillReviewEdit(id);
            }, false);
        })(buttons[i], buttons[i].id);
    }
}, false);

/**
 * Registers the overlay handler with a button and form
 * 
 * @param {type} button - button to register
 * @param {type} id - id of the form to link to button
 * @param {type} secondaryId - link a secondary button
 * @returns {undefined}
 */
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

/**
 * Shows/Hides the modal form submission dialogs
 * 
 * @param {type} id
 * @returns {undefined}
 */
function overlay(id) {
    var element = document.getElementById(id);
    element.style.visibility =
            (element.style.visibility === 'visible') ? 'hidden' : 'visible';
}

/**
 * Populates the review edit form with the proper content
 * 
 * @param {type} reviewId
 */
function fillReviewEdit(reviewId) {
    var id = reviewId.replace("edit_", "");
    document.getElementById("reviewId").value = id;
    
    var reviewBlock = document.getElementById(id);
    var movieTitle = reviewBlock.getElementsByTagName("h3")[0];
    var formHeader = document.getElementById("review_title");
    formHeader.innerHTML = movieTitle.innerText;
    
    var content = reviewBlock.getElementsByClassName("review_content")[0];
    var formContent = document.getElementById("review_form_content");
    formContent.innerHTML = content.innerHTML;
    
    var rating = reviewBlock.getElementsByClassName("rating")[0];
    setRating("edit_movie_rating", rating.innerHTML);
    
}

/**
 * Populate the person edit form
 */
function fillEditPerson() {
    
    var bdate = document.getElementById("person_bdate");
    var bio = document.getElementById("person_bio");
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    
    var editBdate = document.getElementById("bdate");
    var editBio = document.getElementById("bio");
    var editFname = document.getElementById("edit_fname");
    var editLname = document.getElementById("edit_lname");


    editFname.value = fname.innerHTML;
    editLname.value = lname.innerHTML;
    editBio.innerHTML = bio.innerHTML;
    editBdate.value = bdate.innerHTML;
}

/**
 * Populate the movie edit form 
 */
function fillEditMovie() {
    
    var title = document.getElementById("movieTitle").innerHTML;
    document.getElementById("editTitle").value = title;
    
    var rdate = document.getElementById("rdate").innerHTML;
    document.getElementById("releaseDate").value = rdate;
    
    var synopsis = document.getElementById("synopsis").innerHTML;
    document.getElementById("editSynopsis").innerHTML = synopsis;
    
    var director = document.getElementById("dir").innerHTML;
    var directorList = document.getElementById("directorList").getElementsByTagName("option");
    for (var index in directorList) {
        var option = directorList[index];
        if (option.innerHTML === director) {
            option.selected = true;
        }
    }
    
    var allActors = document.getElementById("actorList").getElementsByTagName("option");
    
    var actorList = document.getElementById("actors");
    var actors = actorList.getElementsByTagName("span");
    for (var i in actors) {
        var actor = actors[i];
        if (actor === undefined) {
            continue;
        }
        for (var k in allActors) {
            var check = allActors[k];
            if (check === undefined) {
                continue;
            }
            
            if (actor.innerHTML === check.innerHTML) {
                check.selected = true;
            }
        }
    }
}

/**
 * Sets the Star Rating Field to the appropriate value
 * 
 * @param {type} id - id of the star field to set
 * @param {type} value - value to set 1- 10 (any other value clears)
 */
function setRating(id, value) {
    var span = document.getElementById(id);
    var radioButtons = span.getElementsByTagName("input");
    
    for (var i = 0; i < radioButtons.length; i++) {
        var rdoButton = radioButtons[i];
        rdoButton.checked = rdoButton.value === value.toString();
    }
}