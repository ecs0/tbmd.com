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
               document.getElementById('btnSubmitUser').disabled = true;
               document.getElementById('duplicate_warning').innerHTML = "Email already exists";
            } else {
               document.getElementById('btnSubmitUser').disabled = false;
               document.getElementById('duplicate_warning').innerHTML = "";
            }
         }
      };

      xmlhttp.open("GET", "../php/signup_handler.php?q=" + value, true);
      xmlhttp.send();
   }
}
