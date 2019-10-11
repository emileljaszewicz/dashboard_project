<?php

namespace plugins;


use controller\Controller;
use Entities\Panels;
use library\DBEntity;


class PluginController extends Controller
{
    private $headerScripts = [];
    protected $elements = [];

    protected function render($name, $data = null){
        $pluginInstance = $this->getPluginInstance();
        $pluginPath = $pluginInstance->pluginPath();

        $this->generateHeader("header", $pluginPath."/templates/");
        $this->appendBody($name, $data, $pluginPath."/templates/");
        $this->generateBottom("bottom", $pluginPath."/templates/");
        $a = [];
        foreach ($this->getMergedData() as $html){
            $a[] = $this->pharseHTML($html, $data);
        }
        return $a;
    }
    protected function getPluginInstance(){
        return $this->getPanelEntityObject()->getPluginInstance();
    }
    protected function appendHeaderScripts($data = []){
        $pluginInstance = $this->getPluginInstance();
        $pluginPath = $pluginInstance->pluginPath();
        if(array_key_exists('styles', $data)){
            foreach($data['styles'] as $dataStylePath){
                $this->headerScripts[] = '<link rel="stylesheet" type="text/css" href="'.$pluginPath."/".$dataStylePath.'">';
            }
        }
        if(array_key_exists('scripts', $data)){
            foreach($data['scripts'] as $dataScriptPath){
                $this->headerScripts[] = '<script src="'.$pluginPath."/".$dataScriptPath.'" ></script>';
            }
        }
    }
    public function printHeaderScripts(){
        return implode(PHP_EOL, $this->headerScripts).PHP_EOL;
    }
    protected function getPanelEntityObject(){
        $sessionManager = $this->getSessionManager();
        return new Panels(["panelId" => $sessionManager->getSessionData('panelId')]);
    }
    public function getRoutes(){
        $routeCollection = new RouteCollection();

        return $routeCollection->getRoutes($this);
    }
    protected function isInstanceOf($plugin){
        if($this->getPluginInstance() instanceof $plugin){
            return true;
        }
        else{
            return false;
        }
    }
    protected function pharseHTML($code, $data) {

        $tmp = tmpfile ();
        $tmpf = stream_get_meta_data ( $tmp );
        $tmpf = $tmpf ['uri'];
        fwrite ( $tmp, file_get_contents($code) );
        $ret = include ($tmpf);
        fclose ( $tmp );
        return $ret;
    }

}