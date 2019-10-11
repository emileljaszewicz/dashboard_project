<?php
namespace plugins\yahooWeather\classes;


use library\ArrayParser;

class WeatherConditions
{

    private static $conditionData = [
        'label' => null,
        'image' => null
    ];
    private static $windDirection;
    private static $jsonData;
    private static $data;
    private static $label;
    private static $windSpeed;
    private static $temperature;

    const YAHOO_CONDITIONS = [
        0 =>[
            'label' => 'tornado',
            'image' => ''
        ],
        1 =>[
            'label' => 'tropical storm',
            'image' => ''
        ],
        2 =>[
            'label' => 'hurricane',
            'image' => ''
        ],
        3 =>[
            'label' => 'severe thunderstorms',
            'image' => ''
        ],
        4 =>[
            'label' => 'thunderstorms',
            'image' => ''
        ],
        5 =>[
            'label' => 'mixed rain and snow',
            'image' => ''
        ],
        6 =>[
            'label' => 'mixed rain and sleet',
            'image' => ''
        ],
        7 =>[
            'label' => 'mixed snow and sleet',
            'image' => ''
        ],
        8 =>[
            'label' => 'freezing drizzle',
            'image' => ''
        ],
        9 =>[
            'label' => 'drizzle',
            'image' => ''
        ],
        10 =>[
            'label' => 'freezing rain',
            'image' => ''
        ],
        11 =>[
            'label' => 'showers',
            'image' => ''
        ],
        12 =>[
            'label' => 'rain',
            'image' => ''
        ],
        13 =>[
            'label' => 'snow flurries',
            'image' => ''
        ],
        14 =>[
            'label' => 'light snow showers',
            'image' => ''
        ],
        15 =>[
            'label' => 'blowing snow',
            'image' => ''
        ],
        16 =>[
            'label' => 'snow',
            'image' => ''
        ],
        17 =>[
            'label' => 'hail',
            'image' => ''
        ],
        18 =>[
            'label' => 'sleet',
            'image' => ''
        ],
        19 =>[
            'label' => 'dust',
            'image' => ''
        ],
        20 =>[
            'label' => 'foggy',
            'image' => ''
        ],
        21 =>[
            'label' => 'haze',
            'image' => ''
        ],
        22 =>[
            'label' => 'smoky',
            'image' => ''
        ],
        23 =>[
            'label' => 'blustery',
            'image' => ''
        ],
        24 =>[
            'label' => 'windy',
            'image' => ''
        ],
        25 =>[
            'label' => 'cold',
            'image' => ''
        ],
        26 =>[
            'label' => 'cloudy',
            'image' => ''
        ],
        27 =>[
            'label' => 'mostly cloudy (night)',
            'image' => ''
        ],
        28 =>[
            'label' => 'mostly cloudy (day)',
            'image' => 'ddds'
        ],
        29 =>[
            'label' => 'partly cloudy (night)',
            'image' => ''
        ],
        30 =>[
            'label' => 'partly cloudy (day)',
            'image' => ''
        ],
        31 =>[
            'label' => 'clear (night)',
            'image' => ''
        ],
        32 =>[
            'label' => 'sunny',
            'image' => ''
        ],
        33 =>[
            'label' => 'fair (night)',
            'image' => ''
        ],
        34 =>[
            'label' => 'fair (day)',
            'image' => ''
        ],
        35 =>[
            'label' => 'mixed rain and hail',
            'image' => ''
        ],
        36 =>[
            'label' => 'hot',
            'image' => ''
        ],
        37 =>[
            'label' => 'isolated thunderstorms',
            'image' => ''
        ],
        38 =>[
            'label' => 'scattered thunderstorms',
            'image' => ''
        ],
        39 =>[
            'label' => 'scattered showers (day)',
            'image' => ''
        ],
        40 =>[
            'label' => 'heavy rain',
            'image' => ''
        ],
        41 =>[
            'label' => 'scattered snow showers (day)',
            'image' => ''
        ],
        42 =>[
            'label' => 'heavy snow',
            'image' => ''
        ],
        43 =>[
            'label' => 'blizzard',
            'image' => ''
        ],
        44 =>[
            'label' => 'not available',
            'image' => ''
        ],
        45 =>[
            'label' => 'scattered showers (night)',
            'image' => ''
        ],
        46 =>[
            'label' => 'scattered snow showers (night)',
            'image' => ''
        ],
        47 =>[
            'label' => 'scattered thundershowers',
            'image' => ''
        ]
    ];


    public static function append(ArrayParser $parsedData){
        self::$data[$parsedData->getSearchString()] = $parsedData;

        return new static();
    }

    /**
     * @param string $data
     * @return WeatherConditions
     */
    public static function get(string $data){
        self::$jsonData =  self::$data[$data];
        return new static();
    }
    public static function getWindDirection(){
        if(self::$windDirection === null){
            self::$windDirection = self::$jsonData->get('direction')->value();
        }
        $data = self::$windDirection;
        switch (true){
            case $data > 337.5:
                return "N";
                break;
            case $data > 292.5:
                return "NW";
                break;
            case $data > 247.5:
                return "W";
                break;
            case $data > 202.5:
                return "SW";
                break;
            case $data > 157.5:
                return "S";
                break;
            case $data > 112.5:
                return "SE";
                break;
            case $data > 67.5:
                return "E";
                break;
            case $data > 22.5:
                return "NE";
                break;
            default:
                return "N";
                break;
        }
    }

    public static function getWindSpeed(){
        if(self::$windSpeed === null){
            self::$windSpeed = self::$jsonData->get('speed')->value();
        }
        return self::$windSpeed;
    }
    public static function getTemperature(){
        if(self::$temperature === null){
            self::$temperature = self::$jsonData->get('temperature')->value();
        }
        return  self::$temperature;
    }
    public static function getLabel(){
        if(self::$label === null){
            self::$label = self::$jsonData->get('text')->value();
        }
        return self::$label;
    }
}