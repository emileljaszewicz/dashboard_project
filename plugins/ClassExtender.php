<?php
namespace plugins;



use plugins\pluginsAdmin\PluginControllers\PluginsListController;

abstract class ClassExtender
{
    protected static $pluginInstanceController;
    protected function getPluginController(){
        return self::$pluginInstanceController;
    }
    public static function getClassInstanceName($classInstance){
        $classInstanceNameSplitArray = $stringSplit = explode('\\', $classInstance);

        return end($classInstanceNameSplitArray);
    }
    public static function getClassDirectoryPath($classInstance, $splitLevel){
        $pathOnArray = self::splitStringOnArray($classInstance, '\\', $splitLevel);

        return $pathOnArray;
    }
    private static function splitStringOnArray($string, $delimiter, $splitLevel = null){
        $stringSplit = explode($delimiter, $string, $splitLevel);

        return implode($delimiter, $stringSplit);
    }
}