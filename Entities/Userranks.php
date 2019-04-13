<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 10.03.2019
 * Time: 17:38
 */

namespace Entities;


use library\DBEntity;

class Userranks extends DBEntity
{
    private $userRankId;
    private $rankName;

    /**
     * @return mixed
     */
    public function getUserRankId()
    {
        return $this->userRankId;
    }

    /**
     * @param mixed $userRankId
     */
    public function setUserRankId($userRankId)
    {
        $this->userRankId = $userRankId;
    }

    /**
     * @return mixed
     */
    public function getRankName()
    {
        return $this->rankName;
    }

    /**
     * @param mixed $rankName
     */
    public function setRankName($rankName)
    {
        $this->rankName = $rankName;
    }


}