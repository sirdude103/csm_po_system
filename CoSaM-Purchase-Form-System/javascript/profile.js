/**
 * 
 * Javascript code to handle profile
 * Original creation date: 11/03/18
 * Last modification date: 11/03/18
 * Author: Wyly Andrews
 * */

var form = document.getElementById("profileForm");
var message = document.getElementById("changes");
form.addEventListener("input", function () {
    message.innerHTML = "changes in progress...";
});