$(document).ready(function(){
var $container = getPanelContainer();

var $containerForm = $container.find('form');
var currentMonth = $containerForm.data('month');
var currentYear = $containerForm.data('year');

$container.find('.next').click(function(){
    currentMonth++;
    if(currentMonth > 12){
        currentMonth = 1;
        currentYear = (currentYear+1);
    }
    var data = {
        next: {
            month: currentMonth,
            year: currentYear
        }
    };
    //var $ajaxHtml = ajaxAction('index',  false, data);
    var $ajaxHtml = pluginAction('index',   data, false, false);
    $container.html($ajaxHtml);
});

    $container.find('.previous').click(function(){
        currentMonth--;
        if(currentMonth == 0){
            currentMonth = 12;
            currentYear = (currentYear-1);
        }
        var data = {
            next: {
                month: currentMonth,
                year: currentYear
            }
        };
        var $ajaxHtml = pluginAction('index',   data, false, false);

        $container.html($ajaxHtml);
    });

    $container.find('#kalendarz_kontener').find('.kalendarz_pole').click(function(){
        var calendarFieldContainer, eventDay, eventMonth, eventYear, data, $modal, modalParams, $modalContainer, $modalForm, formData, toSaveData, actionData;

         calendarFieldContainer = $(this);
         eventDay = calendarFieldContainer.text();
         eventMonth = $container.find('form').data('month');
         eventYear = $container.find('form').data('year');
         data = {
            eventDate: eventYear+'-'+eventMonth+'-'+eventDay
        };
         $modal = pluginAction('event', data, false, false);
         modalParams = $($modal).getElementParams($container);
         $modalContainer = $($modal).css({"left": modalParams.toCenterX, "top": modalParams.toCenterY});

        $modalContainer.find('button').click(function(e){
            e.preventDefault();
            $modalForm = $modalContainer.find('form');
             formData = {};
             toSaveData  = {};

            toSaveData.eventDate = dateFormatting(eventYear+'-'+eventMonth+'-'+eventDay);
            $modalForm.find('.modalData').each(function(){

                    formData[$(this).attr('name')] = $(this).val();

            });
            toSaveData.formData = formData;

            if($(this).hasClass('saveEvent')){
                toSaveData.eventAction = 'save';

            }
            else if($(this).hasClass('removeEvent')){
                toSaveData.eventAction = 'remove';
            }
            else{
                toSaveData.eventAction = 'close';
            }
             actionData = JSON.parse(pluginAction($modalForm.attr('action'), toSaveData, false));
            if(actionData.actionResponse === true){
                if(toSaveData.eventAction === 'remove'){
                    calendarFieldContainer.removeClass('event');
                }
                else if(toSaveData.eventAction === 'save'){
                    calendarFieldContainer.addClass('event');
                }
            }
            if($(this).hasClass('saveEvent') || $(this).hasClass('closeEvent') || $(this).hasClass('removeEvent')){
                $modalContainer.remove();
            }
        });

      $container.append($modalContainer);
    });
});