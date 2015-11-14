/**
 * Created by bryan on 11/7/15.
 */
window.addEventListener('load', function() {
    document.getElementById('email').addEventListener('blur',
        validateEmail, false);
}, false);

function validateEmail() {
    var email = document.getElementById('email');

    var value = email.value;

    if (email.value.length !== 0) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                if (xmlhttp.responseText === 'duplicate') {
                    showEmailWarning();
                } else {
                    hideEmailWarning();
                }
            }
        };


        var path = 'php/signup_handler.php?q=' + value;

        //TODO remove this later, its just so bryan's test page still works
        if (window.location.href.indexOf('bryan.php') !== -1) {
            path = '../' + path;
        }

        xmlhttp.open('GET', path, true);
        xmlhttp.send();
    } else {
        hideEmailWarning();
    }
}

function showEmailWarning() {
    document.getElementById('btnSubmitUser').disabled = true;
    document.getElementById('duplicate_warning').innerHTML =
            'Email already exists';
}

function hideEmailWarning() {
    document.getElementById('btnSubmitUser').disabled = false;
    document.getElementById('duplicate_warning').innerHTML = '';
}

