// Js script used to manage the login form

// DOM elements
const messageContainer = document.getElementById("message-container");

// Display login error if present
if (loginError) {
  messageContainer.innerText = loginError;
  messageContainer.style.display = "block";
}
