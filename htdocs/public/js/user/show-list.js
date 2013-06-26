$(function() {
    $(".dialog-password_reset_request_admin").dialog();
});

$(window).load(function() {
    switch (openDialogWindow) {
        
        case (getEnum("WINDOW_PASSWORD_RESET_REQUEST_ADMIN")) :
            $(".dialog-password_reset_request_admin").dialog("open");
            break;
            
    }
});