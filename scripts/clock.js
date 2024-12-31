function updateClock() {
    var currentTime = new Date();
    var currentHours = currentTime.getHours();
    var currentMinutes = currentTime.getMinutes();
    currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
    var currentTimeString = currentHours + ":" + currentMinutes;
    $("#clock").html(currentTimeString);}
    $(document).ready(function () {
    setInterval(updateClock, 1000);
});