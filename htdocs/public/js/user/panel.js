$(function() {
    $(".dialog-password_resetted").dialog();
});

$(window).load(function() {
    switch (openDialogWindow) {
        
        case (getEnum("WINDOW_PASSWORD_RESETTED")) :
            $(".dialog-password_resetted").dialog("open");
            break;
            
    }
});