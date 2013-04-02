$(function() {
    $( document ).tooltip();
    
    $("#dialog-box").dialog({
        autoOpen: false,
        modal: true
    });
    
    $(".dialog-box").dialog({
        autoOpen: false,
        modal: true
    });
    
    $(".deleteButton")
        .button({
            icons: { primary: "ui-icon-trash" }
        })
        .width(16)
        .height(14)
        .css("margin-bottom", "3px");

    $(".resetButton")
        .button({
            icons: { primary: "ui-icon-refresh" }
        })
        .width(16)
        .height(14)
        .css("margin-bottom", "3px");

    $(".editButton")
        .button({
            icons: { primary: "ui-icon-pencil" }
        })
        .width(16)
        .height(14)
        .css("margin-bottom", "3px");

    $(".addButton")
        .button({
            icons: { primary: "ui-icon-plus" },
            label: translate('caption-add')
        });
        
    $("#" + getEnum("SUBMIT_BUTTON"))
        .button({
            label: "dupa"
        });
        
    $("#" + getEnum("FORM_ADD_BUTTON"))
        .button({
            label: translate('caption-add')
        });
        
    $("#" + getEnum("FORM_EDIT_BUTTON"))
        .button({
            label: translate('caption-edit')
        });
        
    $("#" + getEnum("FORM_NEXT_BUTTON"))
        .button({
            label: translate('caption-next')
        });
        
    $("#" + getEnum("FORM_SAVE_BUTTON"))
        .button({
            label: translate('caption-save')
        });
        
    $("#" + getEnum("FORM_LOG_IN_BUTTON"))
        .button({
            label: translate('caption-log_in')
        });
        
});

var confirmationBox = function(url, dialogBoxId) {
    var id = dialogBoxId === undefined ? "dialog-box" : dialogBoxId;
    $("#" + id).dialog({
    resizable: false,
    height:180,
    width:360,
    modal: true,
        buttons : {
            "Tak" : function() {
                location.href = url;
                $(this).dialog("close");
            },
            "Nie" : function() {
                $(this).dialog("close");
            }
        }
    });

    $("#" + id).dialog("open");
};