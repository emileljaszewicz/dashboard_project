<?php
namespace plugins\pluginsAdmin\Classes;


use Entities\Panels;
use plugins\Plugin;

class PluginsAnaliser
{
    private $panel;

    public function __construct(Panels $panel)
    {
        $this->panel = $panel;
    }
    public function getPluginDetails(){
        $pluginPath = $this->panel->getPluginClassName();
        $pluginObject = $this->panel->getPluginInstance();

        if(($pluginObject instanceof Plugin)){
            return $this->getPluginObject($pluginObject);
        }
//        else if(is_object($pluginPath) && (new $pluginPath instanceof Plugin)){
//            return $this->getPluginObject(new $pluginPath);
//        }
        else{
            return $this->panel;
        }
    }
    public function getPanelEntity(){
        return $this->panel;
    }
    public function getPluginStatus(){
        $status = $this->panel->getActive();
        if($status === 1){
            return "Aktywny.";
        }
        else if($status === 2){
            return "Wyłączony.";
        }
        else {
            return $this->panel->getActive();
        }
    }
    public function getPluginId(){
        return $this->panel->getPanelId();
    }
    private function getPluginObject(Plugin $plugin){
        if(is_object($plugin)) {
            return $plugin;
        }
        else{
            return null;
        }
    }
}