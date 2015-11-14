/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var KEY_DOWN = 40;
var KEY_ENTER = 13;

window.addEventListener('load', function() {
    document.getElementById('btnSearch').addEventListener('click',
        search, false);
    document.getElementById('query').addEventListener('keyup', hint, false);
}, false);

function search() {
    var query = document.getElementById('query').value;
    if (query.length === 0) {
        return;
    }

    window.location.href = 'results.php?query=' + query;
}

function hint(e) {
    var str = document.getElementById('query').value;
    if (str.length === 0 || e.keyCode === KEY_DOWN) {
        return;
    }

    if (e.keyCode === KEY_ENTER) {
        search();
        return;
    }

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            var lstData = document.getElementById('search_results');
            var tokens = xmlHttp.responseText.split(',');
            var options = '';
            for (var token in tokens) {
                options += "<option value='" + tokens[token].trim() + "'>";
            }
            lstData.innerHTML = options;
        }
    };


    xmlHttp.open('GET', 'php/search_handler.php?q=' + str, true);
    xmlHttp.send();
}

