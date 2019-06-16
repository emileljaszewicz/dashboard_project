$(document).ready(function(){
    var $container = getPanelContainer();

    $container.find('.navigationContainer .link').click(function(e){
        var linkAction = $(this).data('action');

        getPanelData($container, linkAction);
    });

    $container.find('.pluginContainer').find('button').click(function(){

        var action = $(this).data('action');
        var identificator = parseInt($(this).closest('.pluginContainer').data('id'));
        var panelId = $container.attr('id').split("panel_");
        var $pluginDir = $(this).closest('.pluginContainer').find('.directory');
        var data = {
            panelId: panelId[1],
            pluginId: identificator,
        };
        if($pluginDir.length > 0){
            data.pluginPath = $(this).closest('.pluginContainer').find('.directory')[0].innerText;
        }
            var actionData = JSON.parse(pluginAction(action, data, false));

            if(actionData.actionResponse === 'true'){
                getPanelData($container, 'index');
            }

    });
    $container.find('.userProfileContainer').find('.page').click(function(){
        var newPage = $(this).data('pageId');
        var lastRequest = getLocalStorageUrl();
        console.log(newPage);
        var data = {
            nextPage: newPage,
        };
        getPanelData($container,  lastRequest.ajaxAction, data);

    })
});