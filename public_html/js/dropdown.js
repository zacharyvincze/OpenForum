$(document).ready(function() {
    $(document).click(function() {
        $("#user-dropdown").fadeOut(100);
    });
    
    $("#user-dropdown").click(function(e) {
        e.stopPropagation();
    });
    
    $(".dropbtn").click(function(event) {
        $("#user-dropdown").fadeToggle(100);
        event.stopPropagation();
    });
});