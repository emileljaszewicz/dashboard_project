<?php
namespace plugins\yahooWeather\classes;


class CallYahooWeatherApi
{
    const YAHOO_WEATHER_URL = "https://weather-ydn-yql.media.yahoo.com/forecastrss";
    const YAHOO_APP_ID = "C5QpTF36";
    const YAHOO_CONSUMER_KEY = "dj0yJmk9T3RyNWRZbVpuYW1rJmQ9WVdrOVF6VlJjRlJHTXpZbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmc3Y9MCZ4PWU4";
    const YAHOO_CONSUMER_SECRET = "eb514b032c65c31d046cc9a0f18c6c62c99aa2f8";
    const JSON_RETURN_FORMAT = 'json';
    const XML_RETURN_FORMAT = 'xml';

    private $authParameters = [];
    private $queryParameters = [];
    private $authLink = '';
    private $requestHeader = [];


    public function init(){
        $this->buildAuthData();
        $this->buildAuthorisationLink();
        $this->createAuthHeader();
        return $this;
    }

    public function apiCallResponse(){
        $options = [
            CURLOPT_HTTPHEADER => $this->requestHeader,
            CURLOPT_HEADER => false,
            CURLOPT_URL => self::YAHOO_WEATHER_URL . '?' . http_build_query($this->queryParameters),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ];

       $ch = curl_init();
       curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * @param string $parameterName
     * @param $parameterData
     * @return $this
     */
    public function setQueryParameters(string $parameterName, $parameterData){
        $this->queryParameters[$parameterName] = $parameterData;

        return $this;
    }

    /**
     * @param string $parameterName
     * @param $parameterData
     * @return $this
     */
    private function setAuthParameters(string $parameterName, $parameterData){
        $this->authParameters[$parameterName] = $parameterData;

        return $this;
    }
    private function filterAuthParameters(array $returnParams, $remove = false){
        foreach ($this->authParameters as $authParamName => $authParamValue){
            if($remove == false){
                $removeData = !in_array($authParamName, $returnParams);
            }
            else{
                $removeData = in_array($authParamName, $returnParams);
            }
            if($removeData){
                unset($this->authParameters[$authParamName]);
            }
        }

        return $this->authParameters;
    }
    private function createAuthHeader(){
        $composite_key = rawurlencode(self::YAHOO_CONSUMER_SECRET) . '&';
        $oauth_signature = base64_encode(hash_hmac('sha1', $this->authLink, $composite_key, true));
        //$this->filterAuthParameters(['location', 'format', 'u'], true);
        $this->setAuthParameters('oauth_signature', $oauth_signature);

        $requestHeaderString = 'Authorization: OAuth ';
        $values = [];

        foreach($this->authParameters as $requestParameterName => $requestParameterValue) {
            $values[] = "$requestParameterName=\"" . rawurlencode($requestParameterValue) . "\"";
        }

        $requestHeaderString .= implode(', ', $values);
        $this->requestHeader = [
            $requestHeaderString,
            'X-Yahoo-App-Id: ' . self::YAHOO_APP_ID
        ];

        return $this;
    }
    private function buildAuthorisationLink(){
        $requestData = [];
        $preparedAuthData = array_merge($this->queryParameters, $this->authParameters);
        ksort($preparedAuthData);

        foreach($preparedAuthData as $requestParameterName => $requestParameterValue) {
            $requestData[] = "$requestParameterName=" . rawurlencode($requestParameterValue);
        }

        $this->authLink = "GET" . "&" . rawurlencode(self::YAHOO_WEATHER_URL) . '&' . rawurlencode(implode('&', $requestData));

        return $this;
    }
    private function buildAuthData(){
        $this
            ->setAuthParameters('oauth_consumer_key', self::YAHOO_CONSUMER_KEY)
            ->setAuthParameters('oauth_nonce', uniqid(mt_rand(1, 1000)))
            ->setAuthParameters('oauth_signature_method', 'HMAC-SHA1')
            ->setAuthParameters('oauth_timestamp', time())
            ->setAuthParameters('oauth_version', '1.0');

        return $this;

    }
    private function getAuthData(){
        return $this->authParameters;
    }
}