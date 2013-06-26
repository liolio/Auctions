$(function() {
    $(".dialog-acl_failure").dialog();
    $(".dialog-register").dialog();
    $(".dialog-password_reset_request").dialog();
});

$(window).load(function() {
    switch (openDialogWindow) {
        
        case (getEnum("WINDOW_ACL_FAILURE")) :
            $(".dialog-acl_failure").dialog("open");
            break;
    
        case (getEnum("WINDOW_REGISTER")) :
            $(".dialog-register").dialog("open");
            break;
    
        case (getEnum("WINDOW_PASSWORD_RESET_REQUEST")) :
            $(".dialog-password_reset_request").dialog("open");
            break;
    
    }
});