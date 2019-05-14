<?php

namespace plugins;


use controller\Controller;
use Entities\Panels;


class PluginController extends Controller
{
    private $headerScripts = [];
    protected function render($name, $data = null){
        $pluginInstance = $this->getPanelEntityObject()->getPluginInstance();
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
    protected function appendHeaderScripts($data = []){
        $pluginInstance = $this->getPanelEntityObject()->getPluginInstance();
        $pluginPath = $pluginInstance->pluginPath();
        if(array_key_exists('styles', $data)){
            foreach($data['styles'] as $dataStylePath){
                $this->headerScripts[] = '<link rel="stylesheet" type="text/css" href="'.$pluginPath."/CSS/".$dataStylePath.'">';
            }
        }
        if(array_key_exists('scripts', $data)){
            foreach($data['scripts'] as $dataScriptPath){
                $this->headerScripts[] = '<script src="'.$pluginPath."/js/".$dataScriptPath.'" ></script>';
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