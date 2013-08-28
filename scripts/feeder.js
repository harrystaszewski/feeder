$(function() {
    setTimeout("location.reload(false);",10000);
    showNextMessage();
});

function showNextMessage() {
    $.get("get.message.php", function(data) {
        $("#message").html(data);
    });
    randomTransition();
}

function randomFont() {
    var fontArray = new Array('Rosario', 'Droid Serif', 'Fauna One');
    return fontArray[Math.floor(Math.random()*fontArray.length)];
}

function randomTransition() {
    var transition;
    transition = Math.floor((Math.random()*4)+1);
    $("#message").css({"font-family": randomFont() + ", serif"});
    switch (transition) {
        case 1:
            fromLeft();
            break;
        case 2:
            fromTop();
            break;
        case 3:
            fromRight();
            break;
        case 4:
            fromBottom();
            break;
        default:
            fromLeft();
    }
}

function fromRight () {
    $("#message").css({
        "left": "50%",
        "top": ($(window).height() - $("#message").outerHeight())/2.4
    }).animate({
        left: "0%",
        opacity: 1
    }, 3000);
}

function fromLeft () {
    $("#message").css({
        "top": ($(window).height() - $("#message").outerHeight())/2.4,
        "left": "-50%"
    }).animate({
        left: "0%",
        opacity: 1
    }, 3000);
}

function fromTop () {
    $("#message").css({
        "left": "0%"
    }).animate({
        "top": ($(window).height() - $("#message").outerHeight())/2.4,
        opacity: 1
    }, 3000);
}

function fromBottom() {
    $("#message").css({
        "top": "80%"
    }).animate({
        "top": ($(window).height() - $("#message").outerHeight())/2.4,
        opacity: 1
    }, 3000);
}