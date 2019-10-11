<?php

namespace plugins\yahooWeather\controllers;


use Entities\YahooUserCities;
use library\HTTPMethodHandlerFilter;
use plugins\PluginController;
use plugins\yahooWeather\classes\JsonParser;

class WeatherDisplayController extends PluginController
{
    public function index(){
        $jsonParser = new JsonParser();

        $cityName = $jsonParser->city->value();
        $pageTitle = (strlen($cityName) > 0 ? "Pogoda dla miasta $cityName na {$jsonParser->pubDate->value()}" : "Wybierz miasto");

        $this->appendHeaderScripts([
            'scripts' => ["components/js/search.js"
            ]]);

        $this->setPageTitle($pageTitle);
        return $this->render("weatherHomePage",['JsonParser' => $jsonParser, 'pluginPath' => $this->getPluginInstance()->pluginPath()]);
    }

    public function saveCity(){
        $loggedUserInstance = $this->getUser()->getUserObiect();
        $yahooUserCities = new YahooUserCities(['userId' => $loggedUserInstance->getUserId()]);

        if($yahooUserCities->getIdUserCity() === null){
            $yahooUserCities = new YahooUserCities();
        }

        $postData = HTTPMethodHandlerFilter::handlePost('data');
        $httpParsedData = (new HTTPMethodHandlerFilter())->setMethodsData(json_decode($postData, true));
        $cityName = $httpParsedData->getData('cityName')->getValues();

        $yahooUserCities->setCityName($cityName);
        $yahooUserCities->setUserId($loggedUserInstance->getUserId());
        $yahooUserCities->save();
    }
}