<?php
namespace plugins;


use plugins\pluginsAdmin\Lib;

class PluginAccessor
{
    public function functionInit($functionName, Plugin $plugin){
        $arr = [];
        $controllers = $this->getDirControllers($plugin->pluginControllersPath());

        foreach ($controllers as $controllerName){
            $instancePath = '\\'.str_replace('/','\\', $plugin->pluginControllersPath()).$controllerName;
            $controllerInstance = new $instancePath();
            $controllerRoutes = $controllerInstance->getRoutes();
            $controllerActionArrayIndex = array_search($functionName, $controllerRoutes);
            if(is_int($controllerActionArrayIndex)) {
                $arr[] = [$controllerRoutes[$controllerActionArrayIndex], $instancePath];
            }
        }

        if(sizeof($arr) === 1){
            $controllerInstancePath = $arr[0][1];
            $controllerAction = $arr[0][0];

            return (new $controllerInstancePath())->$controllerAction();
        }
        else{
            return "To many Requests";//To do: Add error reporting for many route requests
        }

    }
    private function getDirControllers($path){
        $directoryContent = scandir($path);
        $contentCollection = [];
        foreach($directoryContent as $dirElement){
            if(is_file($path.$dirElement)){
                $className = explode('.', $dirElement)[0];
                $contentCollection[] = $className;
            }
        }

        return $contentCollection;//is_subclass_of(new PluginAccessor, get_class($this));
    }
}