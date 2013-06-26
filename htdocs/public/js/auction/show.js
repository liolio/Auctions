$(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto({
        social_tools: false,
        default_width: 500,
        default_height: 344
    });
});

$(function() {
    $(".dialog-buy_out").dialog();
    $(".dialog-bid").dialog();
});

$(window).load(function() {
    switch (openDialogWindow) {
        
        case (getEnum("WINDOW_BUY_OUT")) :
            $(".dialog-buy_out").dialog("open");
            break;
        
        case (getEnum("WINDOW_BID")) :
            $(".dialog-bid").dialog("open");
            break;
    }
});