<?php
namespace plugins\yahooWeather\classes;


use Entities\YahooUserCities;
use library\ArrayParser;
use library\HTTPMethodHandlerFilter;
use library\UsersCreator;

class JsonParser
{
    /** @var \Entities\Users  */
    private $loggedUserObject;
    private  $yahooWeather;

    /** @var ArrayParser */
    public $woeid;
    /** @var ArrayParser */
    public $city;
    /** @var ArrayParser */
    public $region;
    /** @var ArrayParser */
    public $country;
    /** @var ArrayParser */
    public $lat;
    /** @var ArrayParser */
    public $timezone_id;
    /** @var ArrayParser */
    public $current_observation = [];
    /** @var ArrayParser */
    public $forecasts = [];
    /** @var ArrayParser */
    public $wind = [];
    /** @var ArrayParser */
    public $pressure;
    /** @var ArrayParser */
    public $humidity;
    /** @var ArrayParser */
    public $sunrise;
    /** @var ArrayParser */
    public $sunset;
    /** @var ArrayParser */
    public $condition = [];
    /** @var ArrayParser */
    public $pubDate;

    public function __construct()
    {
        $this->loggedUserObject = UsersCreator::createFromSession();
        $parsedJsonData = $this->getParsedJsonArray();
        foreach (get_object_vars($this) as $propertyName => $propertyValue){
            $parsedDataCopy = clone $parsedJsonData;
            $this->$propertyName = $parsedDataCopy->get($propertyName);
        }

        $this->condition = WeatherConditions::append($this->condition);
        $this->wind = WeatherConditions::append($this->wind);
        $this->pubDate = (new ArrayParser(['pubDate' => date('d.m.Y H:m', $this->pubDate->value())]))->get('pubDate');

    }
    private function init(){
        $userCity = new YahooUserCities(['userId' => $this->loggedUserObject->getUserId()]);
        $this->yahooWeather = new CallYahooWeatherApi();

        $this->yahooWeather
           // ->setQueryParameters('location', 'wroclaw')
            ->setQueryParameters('location', $userCity->getCityName())
            ->setQueryParameters('format', CallYahooWeatherApi::JSON_RETURN_FORMAT)
            ->setQueryParameters('u', 'c')
            ->init();

        return json_decode($this->yahooWeather->apiCallResponse(), true) ?? [];

    }
    private function getParsedJsonArray(){

        return  new ArrayParser($this->init());
    }
}