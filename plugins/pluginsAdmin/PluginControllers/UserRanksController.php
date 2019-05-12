<?php
namespace plugins\pluginsAdmin\PluginControllers;


use Entities\Panels;
use Entities\RankPanels;
use Entities\Userranks;
use plugins\PluginController;

class UserRanksController extends PluginController
{
    public function userRanks(){
        $userRanks = new Userranks();
        $collection = $userRanks->getCollection();

        $this->setPageTitle('Rangi użytkowników');
        $this->appendHeaderScripts(["scripts" => ["userRanks.js"]]);
        return $this->render('userRanksList', ["ranksObject" => $collection->getCollection()]);
    }

    public function rankSwitch(){
        $jsonData= json_decode($this->postData['data'], true);
        $userRanks = new Userranks(['userRankId' => (int)$jsonData['rankId']]);

        if(!empty($userRanks->getUserRankId())){

            switch ($userRanks->getActive()){
                case '1':
                    $userRanks->setActive(0);
                    break;
                case '0':
                    $userRanks->setActive(1);
            }
            $userRanks->save();

            return true;
        }
        else{
            return false;
        }
    }
    public function rankPrivileges(){
        $jsonData= json_decode($this->postData['data'], true);
        $rankPanels = new RankPanels(['userRankId' => (int)$jsonData['rankId']]);
        $pluginInstance = $this->getPanelEntityObject()->getPluginInstance();
        $pluginPath = $pluginInstance->pluginPath();
        if(is_array($rankPanels->getPanelId())){
            $userPanelsData = $rankPanels->getPanelId();
        }
        else{
            $userPanelsData[] = $rankPanels->getPanelId();
        }
        return $this->pharseHTML($pluginPath.'/templates/rankPrivilegesModal.html.php',['rankPanels' => $userPanelsData, 'panels' => (new Panels())->getCollection()->getCollection()]);
    }
    public function savePrivileges(){
        $jsonData= json_decode($this->postData['data'], true);
        $rankPanels = new RankPanels(['userRankId' => (int)$jsonData['rankId']]);


        if(is_array($rankPanels->getPanelId())){
            $rankPrivileges = $rankPanels->getPanelId();
        }
        else{
            $rankPrivileges[] = $rankPanels->getPanelId();
        }

        foreach ($jsonData['checkboxes'] as $checkboxInfo){
            if(in_array($checkboxInfo['id'], $rankPrivileges)){
                if($checkboxInfo['checked'] === false){
                    $queryBuilder = $this->queryBuilder();
                    $queryBuilder->createQueryForTable($rankPanels->getEntityName());
                    $queryBuilder->prepareData('userRankId', (int)$jsonData['rankId']);
                    $queryBuilder->prepareData('panelId', $checkboxInfo['id']);
                    $queryBuilder->removeData();
                    $queryBuilder->execQuery();
                }
            }
            else{
                if($checkboxInfo['checked'] === true){
                    $queryBuilder = $this->queryBuilder();
                    $queryBuilder->createQueryForTable($rankPanels->getEntityName());
                    $queryBuilder->prepareData('userRankId', (int)$jsonData['rankId']);
                    $queryBuilder->prepareData('panelId', $checkboxInfo['id']);
                    $queryBuilder->insertData();
                    $queryBuilder->execQuery();
                }
            }
        }
    }
}