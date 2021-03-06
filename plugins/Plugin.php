<?php
namespace plugins;


use plugins\pluginsAdmin\Classes\MagicMethods;

abstract class Plugin extends MagicMethods
{
    protected $urlAction;
    protected $actionArgs;
    protected $templatePath;

    public function setUrlAction($urlAction, $actionArgs)
    {

        $pluginAccessor = new PluginAccessor();

        $this->urlAction = $pluginAccessor->functionInit($urlAction, $this);
    }
    public abstract function pluginInfo();
    public abstract function panelImage();
    public abstract function getUrlAction();
    public abstract function pluginPath();
    public abstract function getPluginClassName();
    public abstract function getPluginName();
    public abstract function pluginWidth();
    public abstract function pluginHeight();
    public abstract function pluginControllersPath();
    public abstract function pluginSQL();
}