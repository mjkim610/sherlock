function getUsername() {
    usernameCurrent = document.getElementById("username").value;

    console.log("usernameCurrent: "+usernameCurrent);
}

function getIP() {
    var xhr = new XMLHttpRequest();
    // setting synchronous causes JSON to not be returned properly... why??
    xhr.open("GET", "https://jsonip.com", false);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(null);
    // gets blocked by uBlockOrigin adblocker
    // make sure to disable adblocker when testing
    var responseJSON = JSON.parse(xhr.responseText);
    ipCurrent = responseJSON.ip;

    console.log("ipCurrent: "+ipCurrent);
}

function checkIP() {
    getIP();

    var ipIndex = users.findIndex(function(user, i){
        return user.ip === ipCurrent;
    });

    var usernameIndex = users.findIndex(function(user, i){
        return user.username === usernameCurrent;
    });

    // check if ip corresponds to entered username
    if (ipIndex == usernameIndex)
        return true;
    return false;
}

// each function is a "FEATURE"
// if all "FEATURES" return true, then authentication is passed
// if some "FEATURES" return true, then simple authentication is required
// if all "FEATURES" return false, then full authentication is required
function authenticate() {
    getUsername();
    checkIPResult = checkIP();

    if (checkIPResult == true) {
        alert("Login Success!");
    } else {
        alert("Login Failed...");
        // document.getElementById("inputPin").className = "form-control";
        // document.getElementById("inputPassword").className = "form-control";
    }
}

var usernameCurrent;
var ipCurrent;


// is there a way to import JSON from a separate file?
var users = [
    {"username":"jhoney", "ip":"165.132.1.0"},
    {"username":"sullamij", "ip":"165.132.5.133"},
    {"username":"mjkim610", "ip":"165.132.5.149"}
]

var loginButton = document.getElementById("login");

loginButton.onclick = authenticate;
