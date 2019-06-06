<?php
namespace plugins\pluginsAdmin;


use plugins\Plugin;
use plugins\PluginAccessor;

class PluginsAdministration extends Plugin
{

    public function pluginInfo()
    {
        return [
            "Author" => "Emil Eljaszewicz",
            "Description" => "Plugins management",
        ];
    }

    public function panelImage()
    {
        return "templates/images/control_panel_shortcut.jpg";
    }

    public function pluginPath()
    {
        return "plugins/pluginsAdmin";
    }

    public function getPluginClassName()
    {
        return "PluginsAdministration";
    }

    public function getUrlAction()
    {
        return $this->urlAction;
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
        return "plugins/pluginsAdmin/PluginControllers/";
    }

    public function getPluginName()
    {
        return "Admin plugin list Panel";
    }

    public function pluginSQL()
    {
        // TODO: Implement pluginSQL() method.
    }
}