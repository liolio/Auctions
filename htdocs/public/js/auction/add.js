var delivery = function(id, target) {
    if (target.checked)
    {
        $("#" + getEnum("DELIVERY_PRICE") + "_" + id + "-element").show();
        $("#" + getEnum("DELIVERY_PRICE") + "_" + id + "-label").show();
    }
    else
    {
        $("#" + getEnum("DELIVERY_PRICE") + "_" + id + "-element").hide();
        $("#" + getEnum("DELIVERY_PRICE") + "_" + id + "-label").hide();
    }
};

var auctionTransactionTypeBuyOut = function(target) {
    if (target.checked)
    {
        $("#" + getEnum("AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE") + "-element").show();
        $("#" + getEnum("AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE") + "-label").show();
    }
    else
    {
        $("#" + getEnum("AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE") + "-element").hide();
        $("#" + getEnum("AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE") + "-label").hide();
    }
};

var auctionTransactionTypeBidding = function(target) {
    if (target.checked)
    {
        $("#" + getEnum("AUCTION_TRANSACTION_TYPE_BIDDING_PRICE") + "-element").show();
        $("#" + getEnum("AUCTION_TRANSACTION_TYPE_BIDDING_PRICE") + "-label").show();
    }
    else
    {
        $("#" + getEnum("AUCTION_TRANSACTION_TYPE_BIDDING_PRICE") + "-element").hide();
        $("#" + getEnum("AUCTION_TRANSACTION_TYPE_BIDDING_PRICE") + "-label").hide();
    }
};

var thumbnail = function(index, target) {
    var element = $("#" + getEnum("AUCTION_FILE_ID") + "-" + index)[0];
    console.log(element);
    if (target.value === "") {
        element.checked = false;
        element.disabled = true;
    } else {
        element.disabled = false;
    }
    
};

$(window).load(function() {
    auctionTransactionTypeBuyOut($("#" + getEnum("AUCTION_TRANSACTION_TYPE_BUY_OUT"))[0]);
    auctionTransactionTypeBidding($("#" + getEnum("AUCTION_TRANSACTION_TYPE_BIDDING"))[0]);

    deliveryTypeIds.forEach(function(element, index, array) {
        delivery(element, $("#" + getEnum("DELIVERY_TYPE_ID") + "_" + element)[0]);
    });
    
    for (var load_i = 1; load_i < 6; load_i++) {
        thumbnail(load_i, $("#" + getEnum("FILE") + "_" + load_i)[0]);
    }
});

jQuery(function($) {
    $.datepicker.regional['pl'] = {
            closeText: 'Zamknij',
            prevText: '&#x3c;Poprzedni',
            nextText: 'Następny&#x3e;',
            currentText: 'Dziś',
            monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
            'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
            monthNamesShort: ['Sty','Lu','Mar','Kw','Maj','Cze',
            'Lip','Sie','Wrz','Pa','Lis','Gru'],
            dayNames: ['Niedziela','Poniedzialek','Wtorek','Środa','Czwartek','Piątek','Sobota'],
            dayNamesShort: ['Nie','Pn','Wt','Śr','Czw','Pt','So'],
            dayNamesMin: ['N','Pn','Wt','Śr','Cz','Pt','So'],
            weekHeader: 'Tydz',
            dateFormat: 'yy-mm-dd',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['pl']);
});

deliveryTypeIds.forEach(function(element, index, array) {
    $("#" + getEnum("DELIVERY_TYPE_ID") + "_" + element).change(function(el) {
        return delivery(element, el.target);
    });
});

$("#" + getEnum("AUCTION_TRANSACTION_TYPE_BIDDING")).change(function(el) {
    return auctionTransactionTypeBidding(el.target);
});

$("#" + getEnum("AUCTION_TRANSACTION_TYPE_BUY_OUT")).change(function(el) {
    return auctionTransactionTypeBuyOut(el.target);
});

var currentTime = new Date();

$("#" + getEnum("AUCTION_START_TIME")).datetimepicker({
    dateFormat: "yy-mm-dd",
    timeFormat: "HH:mm:" + "00",
    currentText: translate('caption-now'),
    closeText: translate('caption-ready'),
    timeText: translate('caption-time'),
    hourText: translate('caption-hour'),
    minuteText: translate('caption-minutes'),
    hour: currentTime.getHours(),
    minute: currentTime.getMinutes(),
    minDate: currentTime
});

fileIds.forEach(function(element, index, array) {
    $("#" + getEnum("FILE") + "_" + element)
        .change(function(el) {
            console.log(element);
            thumbnail(element, el.target);
        });
});