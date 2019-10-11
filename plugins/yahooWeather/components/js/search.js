jQuery.fn.searchInit = function(){
    var $container = getPanelContainer();
    $(this).click(function(event){
        var $searchContainer = $('.searchContainer');
        var $titleContainer = $('.titleContainer');
        var $button = $(this);
        var $searchInput = $('input',$searchContainer);
        if($searchContainer.hasClass('enabled')){
            if($searchInput.val().length  > 0){
                pluginAction('saveCity', {
                    cityName: $searchInput.val()
                })
                getPanelData($container, 'index');
            }
            else {
                $searchInput.hide('fast', function () {
                    $titleContainer.show('fast', function () {
                        $('span', $button).removeClass('glyphicon-ok').addClass('glyphicon-search')
                    });
                }).css({"width": "0px"});
                $searchContainer.removeClass('enabled');
            }
        }
        else{
            $titleContainer.hide('fast', function(){
                $searchInput.show('fast', function(){
                    $('span', $button).removeClass('glyphicon-search').addClass('glyphicon-ok')
                }).animate({"width":"200px"});
            });
            $searchContainer.addClass('enabled');

        }
    })
}
$(document).ready(function(){
$('.searchBtn').searchInit();
});

