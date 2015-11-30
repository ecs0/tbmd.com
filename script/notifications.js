window.addEventListener("load", function() {

    var value = getQueryParameter("signup");
    if (value !== false) {
        display("Thanks for signing up for tbmd.com " + value + ", you may sign in now!");
    }
    
    value = getQueryParameter("signin");
    if (value !== false) {
        display("You are now signed in " + value + ". You may edit content on the site.");
    }
    
    value = getQueryParameter("addentity");
    if (value !== false) {
        var type = "added to tbmd.com";
        if (getQueryParameter("edited") === "true") {
            type = " edited.";
        }
        display(value + " successfully " + type);
    }
    
    value = getQueryParameter("addreview");
    if (value !== false) {
        if (getQueryParameter("edited") === "true") {
            display("Your review of " + value + " has been updated.");
        } else {
            display("Your review of " + value + " has been submitted.");
        }
    }
    
}, false);

/**
 * Searches the get paramaters pass to the page for a particular key
 * 
 * @param {type} key - the paramater to search for 
 * @returns {getQueryParameter.getPair|Boolean} - the key's value if found, false otherwise
 */
function getQueryParameter(key) {
    var query = window.location.search.substring(1);
    var getTokens = query.split("&");
    for (var i = 0; i < getTokens.length; i++) {
        var getPair = getTokens[i].split("=");
        if (getPair[0] === key) {
            return getPair[1].replace(new RegExp("%20", 'g'), " ");
        }
    }
    return false;
}

function display(text, failed) {
    $.notify.defaults({ className: failed ? "error" : "success"} );
    $(".top_bar").notify(text, {position: "bottom right"});
}
