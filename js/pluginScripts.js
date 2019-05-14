jQuery.fn.addAlert = function(alertOpen = true,alertType = 'success',message = null){
    var $html = $('<div class="alert-'+alertType+' panel-alert" style="cursor:pointer;top: 20px;border: 1px;"></div>');
    $(this).css({"position":"absolute", "width":"90%"});
    $html.html(message);
    if(alertOpen === true){
        $html.fadeIn(1000);
    }
    else if(alertOpen === false){
        $html.fadeOut(1000);
    }
    $html.click(function () {
        $(this).fadeOut(400);
    });


    $(this).html($html);
}