
$(document).ready(function(){

    var $container = getPanelContainer();

    $container.find('.navigationContainer .link').click(function(e){
        var linkAction = $(this).data('action');
        getPanelData($container, linkAction);
    });

    $container.find('.pluginContainer').find('button').click(function(){
        var lastUrlRequest = getLocalStorageUrl();
        var $modal;
        var action = $(this).data('action');
        var identificator = parseInt($(this).closest('.pluginContainer').data('id'));
        var panelId = $container.attr('id').split("panel_");
        var $pluginDir = $(this).closest('.pluginContainer').find('.directory');
        var data = {
            panelId: parseInt(panelId[1]),
            pluginId: identificator,
        };

        if($pluginDir.length > 0){
            data.pluginPath = $(this).closest('.pluginContainer').find('.directory')[0].innerText;
        }
        if(action === 'unInstall'){
            $modal = $(getDialog('confirmAction'));
            $modal.dialog({
                title: "Dialog Title",
                appendTo: "#panelDialog",
                dialogClass: "no-close",
                buttons: [
                    {
                        text: "odinstaluj",
                        click: function() {
                            var actionData = JSON.parse(pluginAction(action, data, false));

                            if(actionData.actionResponse === 'true'){
                                $( this ).dialog( "close" );
                                $('.user_alert').addAlert(true, 'success', "Poprawnie zainstalowano plugin");
                                setTimeout(function(){
                                    console.log(lastUrlRequest);
                                    getPanelData($container, lastUrlRequest.ajaxAction+"&nextPage="+lastUrlRequest.nextPage);
                                }, 2500);
                            }
                        }
                    },
                    {
                        text: "zamknij",
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                ],
                open: function(a){
                    $container.find('.actions button').attr('disabled', true);
                    return false;
                },
                close: function(){
                    $container.find('.actions button').attr('disabled', false);
                }
            });
            $modal.dialog('open');
        }
        else {
            var actionData = JSON.parse(pluginAction(action, data, false));

            if (actionData.actionResponse === 'true') {
                getPanelData($container, lastUrlRequest.ajaxAction+"&nextPage="+lastUrlRequest.nextPage);
            }
        }

    });
    $container.find('.pluginAdminContainer').find('.page').click(function(){
        var newPage = $(this).data('pageId');
        var lastRequest = getLocalStorageUrl();
        var data = {
            nextPage: newPage,
        };
        getPanelData($container, lastRequest.ajaxAction+"&nextPage="+newPage, data);

    });

    function getDialog(dialogFileName){
        //var panel_Id = $container.attr('id').split("panel_")[1];
        var data = {
            //panelId: panel_Id,
            fileName: dialogFileName
        };
        var $dialogHtml = pluginAction('getDialog', data, false, false);

        return $dialogHtml;
    }
});