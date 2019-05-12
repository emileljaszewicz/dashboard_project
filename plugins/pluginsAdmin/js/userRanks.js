$(document).ready(function(){
   var $panelContainer = getPanelContainer();
   var panel_id = $panelContainer.attr('id').split("panel_")[1];
   $panelContainer.find('.switch').click(function(){
       var rank_id, data, disableResponse;
       rank_id = $(this).closest('.panel').data('id');
       data ={
           panelId: panel_id,
           rankId: rank_id
       };

       disableResponse = JSON.parse(pluginAction('rankSwitch', data, false));

       if(disableResponse.actionResponse === true) {
           getPanelData($panelContainer, 'userRanks');
       }
   });
    $panelContainer.find('.settings').click(function(){
        var $modal, data, rank_id, modalParams, $modalContainer;
        rank_id = $(this).closest('.panel').data('id');
        data = {
            panelId: panel_id,
            rankId: rank_id
        }
            $modal = pluginAction('rankPrivileges', data, false, false);

            modalParams = $($modal).getElementParams($panelContainer);
            $modalContainer = $($modal).css({"left": modalParams.toCenterX, "top": modalParams.toCenterY});

            $modalContainer.find('button').click(function () {
                if ($(this).hasClass('modal-close')) {
                    $modalContainer.remove();
                }
                else if ($(this).hasClass('save')) {
                    pluginAction('savePrivileges', data);
                }
            });
            if($panelContainer.find('#'+$modalContainer.attr('id')).length === 0) {
                $panelContainer.append($modalContainer)
            }
    });
});