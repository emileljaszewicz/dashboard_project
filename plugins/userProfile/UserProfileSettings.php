<?php

namespace plugins\userProfile;


use plugins\Plugin;
use plugins\PluginAccessor;

class UserProfileSettings extends Plugin
{

    public function pluginInfo()
    {
        return [
            "Author" => "Jan Nowak",
            "Description" => "User profile settings",
        ];
    }

    public function panelImage()
    {
        return "templates/images/userProfile.png";
    }

    public function setUrlAction($urlAction, $actionArgs)
    {

        $pluginAccessor = new PluginAccessor();

        $this->urlAction = $pluginAccessor->functionInit($urlAction, $this);
    }

    public function getUrlAction()
    {
        return $this->urlAction;
    }

    public function pluginPath()
    {
        return "plugins/userProfile";
    }

    public function getPluginClassName()
    {
        return "UserProfileSettings";
    }

    public function getPluginName()
    {
        return "User profile plugin";
    }

    public function pluginWidth()
    {
        return "70%";
    }

    public function pluginHeight()
    {
        return "70%";
    }

    public function pluginControllersPath()
    {
        return "plugins/userProfile/PluginControllers/";
    }

    public function pluginSQL()
    {
        // TODO: Implement pluginSQL() method.
    }
}