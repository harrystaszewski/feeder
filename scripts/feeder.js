var tranTime = 3000;
var holdTime = 5000;
var vOffset = 3;

$(function() {
    //window.setInterval(function() {
    //    showNextMessage();
    //}, ((tranTime * 2) + holdTime));
    showNextMessage();
});

function showNextMessage() {
    $.get("get.message.php", function(data) {
        $("#message").html(data);
    })
    .done(function() {
        randomTransition();
    });
}

function randomFont() {
    var fontArray = new Array('Raleway');
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
        "top": ($(window).height() - $("#message").outerHeight())/vOffset
    }).animate({
        left: "0%",
        opacity: 1
    }, tranTime).delay(holdTime).animate({
        opacity: 0
    }, tranTime, function() {
        showNextMessage();
    });
}

function fromLeft () {
    $("#message").css({
        "top": ($(window).height() - $("#message").outerHeight())/vOffset,
        "left": "-50%"
    }).animate({
        left: "0%",
        opacity: 1
    }, tranTime).delay(holdTime).animate({
        opacity: 0
    }, tranTime, function() {
        showNextMessage();
    });
}

function fromTop () {
    $("#message").css({
        "top": "0%",
        "left": "0%"
    }).animate({
        "top": ($(window).height() - $("#message").outerHeight())/vOffset,
        opacity: 1
    }, tranTime).delay(holdTime).animate({
        opacity: 0
    }, tranTime, function() {
        showNextMessage();
    });
}

function fromBottom() {
    $("#message").css({
        "top": "70%",
        "left": "0%"
    }).animate({
        "top": ($(window).height() - $("#message").outerHeight())/vOffset,
        opacity: 1
    }, tranTime).delay(holdTime).animate({
        opacity: 0
    }, tranTime, function() {
        showNextMessage();
    });
}