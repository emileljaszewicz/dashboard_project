<?php
namespace plugins\pluginsAdmin\Classes;


class MagicMethods
{
    public function __call($name, $arguments)
    {
       if(!method_exists($this, $name)){
           return null;
       }
    }
}