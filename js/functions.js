function getPanelContainer(){
    return $('.absolute-window');
}
 function dateFormatting(date){
    var dateOb, day, month, year;
    dateOb = new Date(date);
    day = dateOb.getDate();
    month = dateOb.getMonth()+1;
    year = dateOb.getFullYear();

    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }

    return year+'-'+month+'-'+day;
}
function responsiveWidth($width){
    var percentagle = new RegExp('[%]');
    var resizeWidth =  parseInt($width);
    var documentWidth = $(window).width();

    if(percentagle.test($width)) {

        resizeWidth = (documentWidth * resizeWidth) / 100;
    }

    return resizeWidth;
}
function responsiveHeight($height){
    var percentagle = new RegExp('[%]');
    var resizeHeight =  parseInt($height);
    var documentHeight = $( window ).height();
    if(percentagle.test($height)){
        resizeHeight = (documentHeight*resizeHeight)/100;
    }

    return resizeHeight;
}
function setLocalStorageUrl(url){
    var urlParserLocalStorage = localStorage;

    urlParserLocalStorage.setItem('urlParser', url);
}
function getLocalStorageUrl(){
    var storedUrl = localStorage.getItem('urlParser').split('index.php?');
    var urlGetSegments = storedUrl[1].split('&');
    var urlGetChain = [];
    for(var i in urlGetSegments){
        var urlGet = urlGetSegments[i].split('=');
        urlGetChain[urlGet[0]] = urlGet[1];
    }
    return urlGetChain;
}
jQuery.fn.getElementParams = function($jqueryObject){
    var documentWidth = null;
    var documentHeight = null;

    if(typeof $jqueryObject === 'undefined'){
        $jqueryObject = null;
    }
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
    elementParameters.bottom = documentHeight - (elementPosition.top+elementHeight);
    elementParameters.elementWidth = elementWidth;
    elementParameters.toCenterX = (centerLeft - elementPosition.left);
    elementParameters.toCenterY = (centerTop - elementPosition.top);

    return elementParameters;
}
jQuery.fn.appendLoadingSpinner = function($value){
    if($value === true){
       var $spinnerContainer = $('<img src="styles/img/spinner.gif" width="80" height="80">');
       $spinnerContainer.addClass('spinner-border text-light');
       $spinnerContainer.attr('role', 'status');
       $(this).append($spinnerContainer);

       return $(this);
    }
    else if($value === false){
        $(this).remove();
    }
}
//find examples of DOMSubtreeModified in the web
jQuery.fn.addWatcher = function(){
    $(this).bind('DOMSubtreeModified', function(e) {
        $(this).data('watcherChanges', e);
        $(this).trigger('change');

        return $(this);
    });
}