<?php
namespace plugins\userCalendar\PluginControllers;


use Entities\CalendarEvents;
use plugins\PluginController;
use plugins\userCalendar\Classes\Calendar;

class userCallendarController extends PluginController
{
    public function index(){

        $calendar = new Calendar(date('m'), date('Y'));
        $this->setPageTitle('Kalendarium wydarzeń');
        $this->appendHeaderScripts(['scripts' => ['calendarEvents.js']]);
        return $this->render('calendarEvents', ["dynamicCalendar" => $this->getDate(date('m'), date('Y')), "currentCalendar" => $calendar]);
    }

    public function event(){
        $userOb = $this->getUser()->getUserObiect();
        $eventDate = json_decode($this->postData['data'], true);
        $existedEvent = new CalendarEvents(['userId' => $userOb->getUserId(), 'eventDate' => $eventDate['eventDate']]);
        $date = date_create($eventDate['eventDate']);

        $pluginInstance = $this->getPanelEntityObject()->getPluginInstance();
        $pluginPath = $pluginInstance->pluginPath();

        return $this->pharseHTML($pluginPath.'/templates/modal.html.php', ['date' => date_format($date,"d-m-Y"), 'existedEvent' => $existedEvent]);
    }
    public function saveEvent(){
        $eventModalData = json_decode($this->postData['data'], true);
        $formData = $eventModalData['formData'];
        $userOb = $this->getUser()->getUserObiect();
        $calendarEvents = new CalendarEvents(['userId' => $userOb->getUserId(), 'eventDate' => $eventModalData['eventDate']]);

        if(!empty($formData)) {
            if (empty($calendarEvents->getEventId())) {
                $calendarEvents = new CalendarEvents();
            }
            $calendarEvents->setEventName($formData['eventTitle']);
            $calendarEvents->setDescription($formData['eventDescription']);
            $calendarEvents->setUserId($this->getUser()->getUserObiect()->getUserId());
            $calendarEvents->setEventDate($eventModalData['eventDate']);

            if ($eventModalData['eventAction'] === 'save') {

                $calendarEvents->save();
            } else if ($eventModalData['eventAction'] === 'remove') {

                $calendarEvents->remove();
            }

            return true;
        }
        return false;
    }
    private function getDate($month, $year){
        if(isset($this->postData['data'])) {
            $jsonData = json_decode($this->postData['data'], true);

            if (in_array('previous', array_keys($jsonData))) {
                $month = $this->postData['otherData']['previous'];
            }
            if (in_array('next', array_keys($jsonData))) {
                $month = $jsonData['next']['month'];
                $year = $jsonData['next']['year'];
            }
        }
        $calendar = new Calendar($month, $year);

        return $calendar;
    }
}