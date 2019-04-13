<?php
namespace plugins;




class RouteCollection
{
    private $routes;

    public function findAction($actionName){
        return $this->routes;
    }
    public function getRoutes(PluginController $pluginController){

        return get_class_methods(get_class($pluginController));
    }
}