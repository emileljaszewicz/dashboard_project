<?php
namespace library;


use Entities\Panels;
use plugins\Plugin;

class PluginManager
{
    private $plugin;
    private $pluginParams = [];

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getActionForPlugin($action, $params = []){

        return $this->plugin->setUrlAction($action, $params);
    }

    public function pluginParams(){
        $this->pluginParams = [
            "pluginInfo" => $this->plugin->pluginInfo(),
            "panelImage" => $this->plugin->panelImage(),
            "actionResponse" => $this->plugin->getUrlAction(),
            "pluginPath" => $this->plugin->pluginPath(),
            "pluginClassName" => $this->plugin->getPluginClassName(),
        ];

        return $this->pluginParams;
    }

    public function installPlugin(){
        $panels = new Panels();
        $panels->setPluginClassName($this->plugin->getPluginClassName());
        $panels->setPluginNameSpace(str_replace('/','\\', $this->plugin->pluginPath()));
        $panels->setActive(1);

        if($panels->save()){
            return true;
        }
        return false;
    }

}