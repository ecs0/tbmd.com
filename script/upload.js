var MAX_FILE_SIZE = 2 * 1000 * 1000;


window.addEventListener("load", function() {
    
    for (var i in document.getElementsByName('upload')) {
        var input = document.getElementsByName('upload')[i];
        input.addEventListener("change", checkSize, false);
    }
}, false);

function checkSize(e) {
    var input = e.target;
    var file = input.files[0];
    if (file.size > MAX_FILE_SIZE) {
        window.alert("Your file exceeds the maximum file size for tbmd.com (2mb)");
        input.value = null;
    }
}




