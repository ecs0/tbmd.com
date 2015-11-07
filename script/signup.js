/**
 * Created by bryan on 11/7/15.
 */
window.addEventListener("load", function() {
   document.getElementById('email').addEventListener('blur', validateEmail, false);
}, false);

function validateEmail() {
   var email = document.getElementById('email');

   var value = email.value;

   if (email.value.length != 0) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            if (xmlhttp.responseText == 'duplicate') {
               window.alert("An account using " + value + " already exists in the database.");
               email.value = "";
            }
         }
      };

      xmlhttp.open("GET", "../php/signup_handler.php?q=" + value, true);
      xmlhttp.send();
   }
}
