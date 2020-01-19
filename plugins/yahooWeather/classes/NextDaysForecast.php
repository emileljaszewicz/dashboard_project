<?php


namespace plugins\yahooWeather\classes;


use library\ArrayCollection;
use library\ArrayParser;

class NextDaysForecast
{
    private $nextDaysForecast;
    private $forecastCollection;

    public function __construct(ArrayParser $arrayConditions)
    {
        $this->forecastCollection = new ArrayCollection();
        $this->nextDaysForecast = $arrayConditions->get('forecasts')->value();
    }

    /**
     * @return ArrayCollection
     */
    public function getNextDayForecasts(){
        foreach ($this->nextDaysForecast as $nextDayForecastArray){
            $nextDayForecastArray['code'] = "https://s.yimg.com/os/mit/media/m/weather/images/icons/l/".$nextDayForecastArray['code']."d-100567.png";
            $nextDayForecastArray['date'] = date('d.m.Y', $nextDayForecastArray['date']);
            $this->forecastCollection->add(new ArrayParser($nextDayForecastArray));
        }

        return $this->forecastCollection;
    }
}