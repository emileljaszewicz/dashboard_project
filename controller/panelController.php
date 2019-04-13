<?php
namespace controller;

use Entities\Panels;
use Entities\RankPanels;
use entityExtensions\RankPanelsExtension;
use library\PluginManager;
use userranks\Administrator;


class panelController extends Controller
{
    public function index(){

        $this->appendHeaderScripts(["scripts" => ["js/dashboard.js"]]);

        return $this->render("userMainPage");
    }

    public function getPanels(){
        $loggedUserObject = $this->getUser();

        if($loggedUserObject->getUserRankObject() instanceof Administrator){
            $allowedPanels = new Panels();
            $panelsId = $allowedPanels->getPanelId();
        }
        else{
            $allowedPanels = new RankPanels(['userRankId' => $loggedUserObject->getUserObiect()->getUserId()]);
            $panelsId = $allowedPanels->getPanelId();
        }

        $panelsArray = [];
        foreach($panelsId as  $panesId){
            $panels = new Panels(['panelId' => $panesId]);

                $pluginObject = $panels->getPluginInstance();
                if(($panels->getActive() === '0') && !($loggedUserObject->getUserRankObject() instanceof Administrator)){
                    continue;
                }
                else if($pluginObject !== null) {
                    $panelsArray[] = ['divHtml' => '<div class="animate-panel"><div id="panel_' . $panesId . '" class="panel-content"><img src="' . $pluginObject->pluginPath() . '/' . $pluginObject->panelImage() . '" style="position:absolute" width="100"/></div></div>', 'widthAfter' => $pluginObject->pluginWidth(), 'heightAfter' => $pluginObject->pluginHeight(), 'panelId' => $panesId];
                }

        }

        echo json_encode($panelsArray);
    }
    public function showPanelContent(){

        $panels = new Panels(["panelId" => $this->postData['panelId']]);
        $pluginManager = new PluginManager($panels->getPluginInstance());

        return $pluginManager->getActionForPlugin($_GET['ajaxAction']);

        //echo json_encode($pluginManager->pluginParams());
    }

    public function getPluginAction(){

        $panels = new Panels(["panelId" => $this->postData['panelId']]);
        $pluginManager = new PluginManager($panels->getPluginInstance());

        $pluginManager->getActionForPlugin($_GET['pluginAction']);

        echo json_encode($pluginManager->pluginParams());
    }
}