
var box = document.getElementById("transfer-box");
var button = document.getElementById("transfer-button");
var span = document.getElementsByClassName("transfer-close")[0];
button.onclick = function() {
  box.style.display = "block";
}
span.onclick = function() {
  box.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == box) {
    box.style.display = "none";
  }
}

var account_box = document.getElementById("new-account-box");
var account_button = document.getElementById("new-account-button");
var account_span = document.getElementsByClassName("new-account-close")[0];
account_button.onclick = function() {
  account_box.style.display = "block";
}
account_span.onclick = function() {
  account_box.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == account_box) {
    account_box.style.display = "none";
  }
}

var password_box = document.getElementById("password-box");
var password_button = document.getElementById("password-button");
var password_span = document.getElementsByClassName("password-close")[0];
password_button.onclick = function() {
  password_box.style.display = "block";
}
password_span.onclick = function() {
  password_box.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == password_box) {
    password_box.style.display = "none";
  }
}

var reciever = document.getElementById("select-reciever");

reciever.addEventListener("change", function() {
  if (reciever.value == "other") {
    document.getElementById("account-number").style.display = "block";
  } else {
    document.getElementById("account-number").style.display = "none";
  }
});
