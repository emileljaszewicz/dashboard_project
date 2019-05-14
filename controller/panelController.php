<?php
namespace controller;

use Entities\Panels;
use Entities\RankPanels;
use library\PluginManager;
use userranks\Administrator;

/**
 * @Privileges(isLogged())
 */
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
            $allowedPanels = new RankPanels(['userRankId' => $loggedUserObject->getUserObiect()->getUserRankId()->getUserRankId()]);
            $panelsId = $allowedPanels->getPanelId();
        }
        $panelsArray = [];
        foreach($panelsId as  $panesId){

            $panels = new Panels(['panelId' => $panesId]);

                $pluginObject = $panels->getPluginInstance();
                if(($panels->getActive() === '0') && !($loggedUserObject->getUserRankObject() instanceof Administrator) &&($loggedUserObject->getUserObiect()->getUserRankId()->getActive() === '0')){
                    continue;
                }
                else if($pluginObject !== null) {
                    $panelsArray[] = ['divHtml' => '<div class="animate-panel"><div id="panel_' . $panesId . '" class="panel-content"><img src="' . $pluginObject->pluginPath() . '/' . $pluginObject->panelImage() . '" style="position:absolute" class="responsive-panel" /></div></div>', 'widthAfter' => $pluginObject->pluginWidth(), 'heightAfter' => $pluginObject->pluginHeight(), 'panelId' => $panesId];
                }

        }

        echo json_encode($panelsArray);
    }
    public function showPanelContent(){
        $sessionManager = $this->getSessionManager();
        $sessionManager->addSessionData('panelId', (int)$this->postData['panelId']);

        $panels = new Panels(["panelId" => $sessionManager->getSessionData('panelId')]);
        $pluginManager = new PluginManager($panels->getPluginInstance());

        return $pluginManager->getActionForPlugin($_GET['ajaxAction']);

        //echo json_encode($pluginManager->pluginParams());
    }
    /**
     * @Privileges(isMethod(POST))
     * @SkipSearching(skip(true))
     */
    public function logout(){
        session_destroy();
    }
    /**
     * @Privileges(isMethod(POST))
     * @SkipSearching(skip(true))
     */
    public function getPluginAction(){
        $sessionManager = $this->getSessionManager();
        $panels = new Panels(["panelId" => $sessionManager->getSessionData('panelId')]);
        $pluginManager = new PluginManager($panels->getPluginInstance());

        $pluginManager->getActionForPlugin($_GET['pluginAction']);
        if($this->postData['response'] === 'true') {
            echo json_encode($pluginManager->pluginParams());
        }
    }
}