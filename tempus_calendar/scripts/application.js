var main = function() {
    $("button").hover(function() {
        $(this).toggleClass("button-click");
    });
    $("#add-todo").click(function() {
        var text = $("#todo-area").val();
        $(".todo-list").append("<li class='item'>" + text + "</li>").fadeIn(1700);
    });

    // for daily page
    $("#yesterday").click(function() {
       var today = new Date();
       var yesterday = today.setDate(today.getDate() - 1);
       $("#hidden-date").html("<?php $now = '" + yesterday + "'; drawData($now); ?>");
    });
    $("#tomorrow").click(function() {
       var today = new Date();
       var tomorrow = today.setDate(today.getDate() + 1);
       $("#hidden-date").html("<?php $now = '" + tomorrow + "'; drawData($now); ?>");
    });
    
};

$(document).ready(main);