var main = function() {
    $("button").hover(function() {
        $(this).toggleClass("button-click");
    });
    $("#add-todo").click(function() {
        var text = $("#todo-area").val();
        $(".todo-list").append("<li class='item'>" + text + "</li>").fadeIn(1700);
    });

    
};

$(document).ready(main);