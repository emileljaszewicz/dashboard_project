<?php
namespace plugins\testPlugin;


use plugins\Plugin;

class NewPluginTest extends Plugin
{

    public function pluginInfo()
    {
        return [
            "Author" => "Jan Nowak",
            "Description" => "aaa",
        ];
    }

    public function panelImage()
    {
        // TODO: Implement panelImage() method.
    }

    public function setUrlAction($urlAction, $actionArgs)
    {
        // TODO: Implement setUrlAction() method.
    }

    public function getUrlAction()
    {
        // TODO: Implement getUrlAction() method.
    }

    public function pluginPath()
    {
        return "plugins/testPlugin";
    }

    public function getPluginClassName()
    {
       return "NewPluginTest";
    }

    public function pluginWidth()
    {
        // TODO: Implement pluginWidth() method.
    }

    public function pluginHeight()
    {
        // TODO: Implement pluginHeight() method.
    }

    public function pluginControllersPath()
    {
        // TODO: Implement pluginControllersPath() method.
    }

    public function getPluginName()
    {
        return "Test plugin";
    }
}