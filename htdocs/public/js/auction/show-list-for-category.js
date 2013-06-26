$(function() {
    $(".dialog-auction_deleted").dialog();
});

$(window).load(function() {
    switch (openDialogWindow) {
        
        case (getEnum("WINDOW_AUCTION_DELETED")) :
            $(".dialog-auction_deleted").dialog("open");
            break;
        
    }
});