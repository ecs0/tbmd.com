/**
 * 'Modal' dialogs for entering user input
 * Created by bryan on 11/7/15.
 */

window.addEventListener("load", function() {
    document.getElementById("add_person").addEventListener("click", overlay, false);
    document.getElementById("add_person_close").addEventListener("click", overlay, false);
}, false);

function overlay() {
    var element = document.getElementById("overlay");
    element.style.visibility = (element.style.visibility == "visible") ? "hidden" : "visible";
}

