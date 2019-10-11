<?php
namespace library;


class HTTPMethodHandlerFilter
{
    private $mergedArrayData = [];
    private $arrayDataReturn;

    public function setMethodsData($httpMethodsData){
        if(is_array($httpMethodsData)) {
            $this->mergedArrayData = $this->removeArrayIndexes(array_merge($httpMethodsData));
        }
        else{
            $this->mergedArrayData = $httpMethodsData ?? [];
        }

        return $this;
    }
    public function getData($methodIndexName){
        return (new HTTPMethodHandlerFilter())->setMethodsData((array_key_exists($methodIndexName, $this->mergedArrayData)? $this->mergedArrayData[$methodIndexName]: ""));
    }

    public function getValues(){
        return $this->mergedArrayData;
    }
    public function removeArrayIndexes($arrayData){
            $formattedArray = [];
            foreach ($arrayData as $arrayKey => $value) {
                if (is_string($arrayKey)) {
                    $formattedArray[$arrayKey] = $value;
                } else if(!is_null($value)){
                    return $this->removeArrayIndexes($value);
                }
                else{
                    continue;
                }
            }
            return $formattedArray;

    }
    public static function handleGet($index){
        $data = filter_input(INPUT_GET, $index);
        return $data;
    }
    public static function handlePost($index){
        $data = filter_input(INPUT_POST, $index);
        return $data;
    }

}