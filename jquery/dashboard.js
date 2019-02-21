function printPanels() {
    $.ajax({
        url: "panels.php",
        dataType: "json",
        method: "GET",
    })
        .done(function(response){
            var interval = 1;
            for (var i = 0; i < response.length; i++) {
                const panel = $(response[i].divHtml).delay(interval).fadeIn(1000);
                $('#showPanels').append(panelModify(response[i],panel));
                interval += 3;
            }

        })
        .error(function(){
            console.log('sss');
        })
}

function panelModify(response, $element){
    var $elementDiv = $element.find('.panel-content');
    $elementDiv.click(function(e){
        var floatedDif = $('.absolute-window');
        e.stopPropagation();
        var divs = $('.panel-content');
        for (var j=0; j < divs.length; j++){
            if($(divs[j]).attr('id') === $(this).attr('id')){
                if(floatedDif.length === 0) {
                    $(this).addClass('absolute-window');
                    $(this).sizeIn(response);
                }
            }
            else{
                $(divs[j]).sizeBack();
            }
        }


    });


    return $element;
}
function getElementParams($element){
    var documentWidth = $( window ).width();
    var documentHeight = $( window ).height();
    var elementWidth = $element.width();
    var elementHeight = $element.height();
    var elementPosition = $($element).offset();
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
jQuery.fn.sizeIn = function(response){
    var elementParams = getElementParams($(this));
    $(this)
        .animate({
            top: ((elementParams.toCenterY)-(response.heightAfter/2)),
            left: ((elementParams.toCenterX)-(response.widthAfter/2)),
            width: response.widthAfter+"px",
            height: response.heightAfter+"px"
        }, 300);

    console.log(response.heightAfter);
    console.log(response.widthAfter);
    console.log("top: "+((elementParams.toCenterY)-(response.heightAfter/2)));
    console.log("left: "+((elementParams.toCenterX)-(response.widthAfter/2)));
};

jQuery.fn.sizeBack = function(){
    $(this)
        .animate({
            width: "50px",
            height: "50px",
            left: "0px",
            top: "0px",
        }, 300, "linear", function(){
            $(this).removeClass('absolute-window');
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