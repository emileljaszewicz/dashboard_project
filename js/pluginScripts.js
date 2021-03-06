jQuery.fn.addAlert = function(alertOpen,alertType,message){
    var $html;

    if(typeof alertType === 'undefined'){
        alertType = 'success';
    }
    $html = $('<div class="alert-'+alertType+' panel-alert" style="cursor:pointer;top: 5px;"></div>');
    if(typeof alertOpen === 'undefined'){
        alertOpen = true;
    }
    if(typeof message === 'undefined'){
        message = null;
    }
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