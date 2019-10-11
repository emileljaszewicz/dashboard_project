<?php
namespace plugins\yahooWeather;


use plugins\Plugin;

class YahooWeatherPlugin extends Plugin
{

    public function pluginInfo()
    {
        return [
            "Author" => "Emil Eljaszewicz",
            "Description" => "Yahoo forecast"
        ];
    }

    public function panelImage()
    {
       return "templates/images/yahoo-forecast-icon.jpg";
    }

    public function getUrlAction()
    {
        return $this->urlAction;
    }

    public function pluginPath()
    {
        return "plugins/yahooWeather";
    }

    public function getPluginClassName()
    {
        return "YahooWeatherPlugin";
    }

    public function getPluginName()
    {
        return "Yahoo forecast";
    }

    public function pluginWidth()
    {
        return "50%";
    }

    public function pluginHeight()
    {
        return "80%";
    }

    public function pluginControllersPath()
    {
        return "plugins/yahooWeather/controllers/";
    }

    public function pluginSQL()
    {
        // TODO: Implement pluginSQL() method.
    }
}