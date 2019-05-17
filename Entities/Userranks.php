<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 10.03.2019
 * Time: 17:38
 */

namespace Entities;


use library\DBEntity;
use library\UsersCreator;

class Userranks extends DBEntity
{
    private $userRankId;
    private $rankName;
    private $active;
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

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return UsersCreator
     */
    public function getUserRankObject(){
        $usersCreator = new UsersCreator();
        $usersCreator->findUser([$this->getPrimaryKeyValue()[0]['keyName'] => $this->getPrimaryKeyValue()[0]['keyValue']]);

        return $usersCreator->getUserRankObject();
    }

}