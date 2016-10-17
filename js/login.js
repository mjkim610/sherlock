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

    return ipCurrent.split('.');
}