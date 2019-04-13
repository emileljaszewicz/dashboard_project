<?php
namespace Entities;


use library\DBEntity;

class Panels extends DBEntity
{
    private $panelId;
    private $pluginClassName;
    private $pluginNameSpace;
    private $active;
    private $creationDate;

    /**
     * @return mixed
     */
    public function getPanelId()
    {
        return $this->panelId;
    }

    /**
     * @param mixed $panelId
     */
    public function setPanelId($panelId)
    {
        $this->panelId = $panelId;
    }

    /**
     * @return mixed
     */
    public function getPluginClassName()
    {
        return $this->pluginClassName;
    }

    /**
     * @param mixed $panelClassName
     */
    public function setPluginClassName($pluginClassName)
    {
        $this->pluginClassName = $pluginClassName;
    }

    /**
     * @return mixed
     */
    public function getPluginNameSpace()
    {
        return $this->pluginNameSpace;
    }

    /**
     * @param $pluginNameSpace
     */
    public function setPluginNameSpace($pluginNameSpace)
    {
        $this->pluginNameSpace = $pluginNameSpace;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }


    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getPluginInstance(){
        $PanelObject = $this->pluginNameSpace.'\\'.$this->pluginClassName;

        if(file_exists(str_replace('\\', '/', $PanelObject).'.php')) {
            return new $PanelObject();
        }
        else{
            return null;
        }
    }
}