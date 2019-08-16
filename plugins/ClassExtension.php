<?php
namespace plugins;


class ClassExtension extends ClassExtender
{
    public static function extendClass($pluginsListControllerInstance){
        self::$pluginInstanceController = $pluginsListControllerInstance;
        $pluginName = ClassExtender::getClassInstanceName(get_class($pluginsListControllerInstance));
        $pluginDirPath = ClassExtender::getClassDirectoryPath(get_class($pluginsListControllerInstance), -2);
        $extensionDirName = $pluginDirPath.'\\classExtensions\\';
        $pluginExtensionClassName = '\\'.$extensionDirName.$pluginName.'Extension';

        if(!is_dir($extensionDirName)){
            throw new \Exception("Directory $extensionDirName doesn`t exists");
            exit;
        }
        if(!class_exists($pluginExtensionClassName)){
            throw new \Exception("Object $pluginExtensionClassName doesn`t exists");
            exit;
        }

        return new $pluginExtensionClassName($pluginsListControllerInstance);
    }
}