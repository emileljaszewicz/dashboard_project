<?php

namespace plugins;


use controller\Controller;
use Entities\Panels;


class PluginController extends Controller
{
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
    protected function getPanelEntityObject(){
        return new Panels(["panelId" => $this->postData['panelId']]);
    }
    public function getRoutes(){
        $routeCollection = new RouteCollection();

        return $routeCollection->getRoutes($this);
    }
    private function pharseHTML($code, $data) {

        $tmp = tmpfile ();
        $tmpf = stream_get_meta_data ( $tmp );
        $tmpf = $tmpf ['uri'];
        fwrite ( $tmp, file_get_contents($code) );
        $ret = include ($tmpf);
        fclose ( $tmp );
        return $ret;
    }
}