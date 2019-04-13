<?php
namespace Entities;


use library\DBEntity;

class RankPanels extends DBEntity
{
    private $userRankId;
    private $panelId;

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
    public function getPanelId()
    {
        return $this->panelId;
    }

    /**
     * @param mixed $panelId
     */
    public function setPanelId($panelId)
    {
        $this->panelId = $panelId;
    }


}