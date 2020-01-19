<?php
namespace library;


class ArrayCollection
{
    private $collectionArray = [];

    public function add($collectionContent){
        $this->collectionArray[] = serialize($collectionContent);
    }
    public function getCollection(){
        return array_map(function($collectionObject){
            return unserialize($collectionObject);
        }, $this->collectionArray);
    }
    public function getFirst(){
        $unSerializedCollection = $this->getCollection();
        return reset($unSerializedCollection);
    }
    public function getLast(){
        $unSerializedCollection = $this->getCollection();
        return end($unSerializedCollection);
    }
}