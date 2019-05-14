$(document).ready(function() {
    var $container = getPanelContainer();

    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';

    $('.toSave').editable({
        success: function(response, values) {
            var $inputName = $(this).attr('id');
            var panelId = $container.attr('id').split("panel_");
            var responseResult = null;
            var data = {};
            data[$inputName] = values;
            var requestData = {
                panelId: panelId[1],
                values:data,
            }

            responseResult = JSON.parse(pluginAction('saveData', requestData, false));
            if(responseResult.actionResponse !== true){
                var responseHTML = '';
                for(var alert in responseResult.actionResponse){
                    var $inputContainer = $container.find('#'+alert).parent().closest('.positionContainer');
                    var labelContent = $inputContainer.find('.profileLabel');
                   var message = responseResult.actionResponse[alert].toLowerCase().split(alert.toLowerCase());


                    responseHTML += "Field "+labelContent.text()+" "+message[1]+"</br>";

                }

                $('.user_alert').addAlert(true, 'danger', responseHTML);
                return false;
            }
            else{
                $('.user_alert').addAlert(false);
            }
        }
    });

    $('#password').editable({
        //url: pluginAction('saveData', $container),
        success: function(response, values) {
            var panelId = $container.attr('id').split("panel_");
            var responseResult = null;
            var requestData = {
                panelId: panelId[1],
                values,
            }
            responseResult = JSON.parse(pluginAction('saveData', requestData, false));
            if(responseResult.actionResponse !== true){
                var responseHTML = '';
                for(var alert in responseResult.actionResponse){
                    var labelContent = $container.find('#'+alert);
                    var message = responseResult.actionResponse[alert].toLowerCase().split(alert.toLowerCase());


                    responseHTML += "Field "+labelContent.text()+" "+message[1]+"</br>";
                }
                $('.user_alert').addAlert(true, 'danger', responseHTML);
                return false;
            }
            else{
                $('.user_alert').addAlert(false);
            }
        }
    });

});
