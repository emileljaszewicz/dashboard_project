function getPanelContainer(){
    return $('.absolute-window');
}
jQuery.fn.getElementParams = function($jqueryObject = null){
    var documentWidth = null;
    var documentHeight = null;

    if($jqueryObject === null) {
        documentWidth = $(window).width();
        documentHeight = $(window).height();
    }
    else{
        documentWidth = $jqueryObject.width();
        documentHeight = $jqueryObject.height();
    }
    var elementWidth = $(this).outerWidth();
    var elementHeight = $(this).outerHeight();
    var elementPosition = $(this).offset();
    var elementParameters = {};
    var centerLeft = (documentWidth-elementWidth)/2;
    var centerTop = (documentHeight-elementHeight)/2;

    elementParameters.left = elementPosition.left;
    elementParameters.right = documentWidth - (elementPosition.left+elementWidth);
    elementParameters.top = elementPosition.top;
    elementParameters.bottom = documentHeight - (elementPosition.top+elementHeight)
    elementParameters.elementWidth = elementWidth;
    elementParameters.toCenterX = (centerLeft - elementPosition.left);
    elementParameters.toCenterY = (centerTop - elementPosition.top);
    return elementParameters;
}
jQuery.fn.appendLoadingSpinner = function($value){
    if($value === true){
       var $spinnerContainer = $('<div></div>');
       $spinnerContainer.addClass('spinner-border text-light');
       $spinnerContainer.css({"width":"50px", "height":"50px"});
       $spinnerContainer.attr('role', 'status');
       $(this).append($spinnerContainer);

       return $(this);
    }
    else if($value === false){
        $(this).remove();
    }
}