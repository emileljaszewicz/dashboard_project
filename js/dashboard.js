var enabled = false;
function printPanels() {
    var ajaxRequest =ajaxFunction();

    ajaxRequest.onreadystatechange = function () {
        var $pageLoader = $('#loader');
        $pageLoader.css({"width":"1px", "height":"1px"});
        if(this.readyState == 4 && this.status == 200){
            $pageLoader.appendLoadingSpinner(false);
            var responseData = this.responseText;
            var response = JSON.parse(responseData);


            var interval = 1;
            for (var i = 0; i < response.length; i++) {
                const panel = $(response[i].divHtml).delay(interval).fadeIn(1000);

                $('#showPanels').append(panelModify(response[i],panel));
                interval += 3;
            }
        }
        else{
            var $loaderParams = $pageLoader.getElementParams();
            $pageLoader.appendLoadingSpinner(true);
            $pageLoader.css({"margin-left":$loaderParams.toCenterX+"px", "margin-top":$loaderParams.toCenterY+"px"});
        }

    }
    ajaxRequest.open("GET", "index.php?task=panel&action=getPanels", true);
    ajaxRequest.send();

}

function panelModify(response, $element){
    var $elementDiv = $element.find('.panel-content');
    $elementDiv.click(function(e){
        var floatedDif = $('.absolute-window');
        e.stopPropagation();
        e.preventDefault();
        var divs = $('.panel-content');
        if(enabled === false) {
            for (var j = 0; j < divs.length; j++) {

                if ($(divs[j]).attr('id') === $(this).attr('id')) {
                    if (floatedDif.length === 0) {
                        var contentBeforeResize = $(this)[0].innerHTML;

                        $(this).data('beforeChange', contentBeforeResize);
                        $(this).empty();
                        $(this).addClass('absolute-window');
                        $(this).sizeIn(response);
                    }
                } else {
                    $(divs[j]).sizeBack();
                }
            }
            enabled = true;
        }

    });


    return $element;
}
function getPanelData($container, $url, containerData = null){
    var ajaxRequest = ajaxFunction();
    var $loadSpinner = $('<div id="loadSpinner"></div>');
    var data = new FormData();
    data.append('otherData', JSON.stringify(containerData));
    if(containerData !== null && containerData.panelId !== undefined) {
        $(this).data('lastInsertedId', containerData.panelId);
        data.append('panelId', containerData.panelId);
    }
    else{
        data.append('panelId', $(this).data('lastInsertedId'));
    }
    ajaxRequest.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            $loadSpinner.appendLoadingSpinner(false);
            var responseData = this.responseText;
            $container.html($(responseData));

        }
        else{
                var $lS = $loadSpinner.appendLoadingSpinner(true);
                $lS.attr('style', $lS.find('div').attr('style'));
                $lS.css({
                    "margin-left": $lS.getElementParams($($container)).toCenterX + "px",
                    "margin-top": $lS.getElementParams($($container)).toCenterY + "px"
                });
                $($container).html($lS);
        }

    }
    ajaxRequest.open("POST", "index.php?task=panel&action=showPanelContent&ajaxAction="+$url, true);
    ajaxRequest.send(data);
}
function pluginAction($url, containerData = null, async = true){
    var responseContent = null;
    var ajaxRequest = ajaxFunction();
    var data = new FormData();
    data.append('panelId', containerData.panelId);
    data.append('data', JSON.stringify(containerData));

    ajaxRequest.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            if(async === false) {
                var responseData = this.responseText;

                responseContent = responseData;
            }

        }
        else{

        }

    }
    ajaxRequest.open("POST", "index.php?task=panel&action=getPluginAction&pluginAction="+$url, async);
    ajaxRequest.send(data);

    return responseContent;
}
jQuery.fn.sizeIn = function(response){
    var percentagle = new RegExp('[%]');
    var elementParams = $(this).getElementParams();
    var resizeWidth =  parseInt(response.widthAfter);
    var resizeHeight =  parseInt(response.heightAfter);

    if(percentagle.test(response.widthAfter)) {
        var documentWidth = $(window).width();

        resizeWidth = (documentWidth * resizeWidth) / 100;
    }
    if(percentagle.test(response.heightAfter)){
        var documentHeight = $( window ).height();

        resizeHeight = (documentHeight*resizeHeight)/100;
    }
    $(this)
        .animate({
            top: ((elementParams.toCenterY)-(resizeHeight/2)),
            left: ((elementParams.toCenterX)-(resizeWidth/2)),
            width: resizeWidth,
            height: resizeHeight
        }, 200, function() {
            getPanelData($(this), 'index', response);
        });
};

jQuery.fn.sizeBack = function(){
    $(this)
        .animate({
            width: "100px",
            height: "100px",
            left: "0px",
            top: "0px",
        }, 200, "linear", function(){
            $(this).removeClass('absolute-window');
            $(this).html($(this).data('beforeChange'));
            $('#todelete').remove();
            enabled = false;
        });
    return $(this);
};

$(document).ready(function(){
    printPanels();
})
    .click(function(){
        $('.absolute-window')
            .sizeBack();
    });