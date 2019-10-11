<?php
namespace library;


class ArrayParser
{
    private $dataToParse = [];
    private $searchResults = [];
    private $search;
    public function __construct(array $dataToPArse)
    {
        $this->dataToParse = $dataToPArse;
    }


    public function get(string $dataToGet){

        foreach ($this->dataToParse as $keyName => $keyValue){
            if(is_array($keyValue)){
                if($keyName === $dataToGet){
                    $this->searchResults[$keyName] = $keyValue;
                }
                else {
                    $this -> __construct($keyValue);
                    $this->get($dataToGet);
                }
            }
            else{
                if($keyName === $dataToGet){
                    $this->searchResults[$keyName][] = $keyValue;
                }
            }
        }
        return (new ArrayParser($this->searchResults))->setSearchString($dataToGet);
    }

    public function value(){
        if(!array_key_exists($this->search, $this->dataToParse)){
            return null;
        }
        if(sizeof($this->dataToParse[$this->search]) > 1){

            return $this->dataToParse[$this->search] ?? $this->dataToParse;
        }
        else if(sizeof($this->dataToParse[$this->search]) == 1){

            return current($this->dataToParse[$this->search]) ?? current($this->dataToParse);
        }

    }
    public function getSearchString(){
        return $this->search;
    }
    public function setSearchString(string $search){
        $this->search = $search;
        return $this;
    }
}