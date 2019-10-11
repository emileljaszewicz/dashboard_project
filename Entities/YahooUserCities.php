<?php
namespace Entities;

use library\DBEntity;

class YahooUserCities extends DBEntity
{
    private $idUserCity;
    private $cityName;
    private $userId;

    /**
     * @return mixed
     */
    public function getIdUserCity()
    {
        return $this->idUserCity;
    }

    /**
     * @param mixed $idUserCity
     */
    public function setIdUserCity($idUserCity)
    {
        $this->idUserCity = $idUserCity;
    }

    /**
     * @return mixed
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * @param mixed $cityName
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

}