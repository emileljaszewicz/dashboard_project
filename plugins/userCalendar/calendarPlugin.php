<?php
namespace plugins\userCalendar;

use plugins\Plugin;
use plugins\PluginAccessor;

class calendarPlugin extends Plugin
{

    public function pluginInfo()
    {
        return [
          "Author" => "Emil Eljaszewicz",
          "Description" => "Organisation of user events"
        ];
    }

    public function panelImage()
    {
        return "templates/images/calendar.png";
    }

    public function getUrlAction()
    {
        return $this->urlAction;
    }

    public function pluginPath()
    {
        return 'plugins/userCalendar';
    }

    public function getPluginClassName()
    {
        return "calendarPlugin";
    }

    public function getPluginName()
    {
        return "User events";
    }

    public function pluginWidth()
    {
        return "70%";
    }

    public function pluginHeight()
    {
        return "80%";
    }

    public function pluginControllersPath()
    {
        return "plugins/userCalendar/PluginControllers/";
    }

    public function pluginSQL()
    {
        // TODO: Implement pluginSQL() method.
    }
}