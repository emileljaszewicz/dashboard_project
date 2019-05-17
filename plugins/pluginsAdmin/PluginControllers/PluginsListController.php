<?php
namespace plugins\pluginsAdmin\PluginControllers;



use Entities\Panels;
use library\PluginManager;
use library\Scanner;
use plugins\PluginController;

class PluginsListController extends PluginController
{
    public function index(){
        $userObject = $this->getUser()->getUserObiect();
        $requestManager = $this->getRequestManager();
        $nextPageInfo = $requestManager->getPostData('otherData');

        if(isset(json_decode($nextPageInfo)->nextPage)){
            $nextPage = json_decode($nextPageInfo)->nextPage;
        }

        $this->appendHeaderScripts(["styles" => [], "scripts" => []]);
        $this->setPageTitle('Lista dostępnych pluginów');
        return $this->render('pluginList', [
            "stats" => array_merge($this->getInstalledPlugins(), $this->getExistedPlugins()),
            "PluginInstance" => $this->getPluginInstance()]);
    }
    public function secondAction(){
        $this->appendHeaderScripts(["styles" => ['aaa.css'], "scripts" => ["qqqq.js"]]);
        return $this->render('test2');
    }
    public function enable(){
        $pluginData = json_decode($this->postData['data']);
        $panels = new Panels(["panelId" => $pluginData->pluginId]);
        $panels->setActive(1);

        if($panels->save() && ($pluginData->pluginId !== null)) {
            return 'true';
        }
        else{
            return 'false';
        }
    }
    public function disable(){
        $pluginData = json_decode($this->postData['data']);
        $panels = new Panels(["panelId" => $pluginData->pluginId]);
        $panels->setActive(0);

        if(!$this->isInstanceOf($panels->getPluginInstance())) {
            $panels->save();

            return 'true';
        }
        else{
            return 'false';
        }
    }
    public function install(){
        try {
            $pluginData = json_decode($this->postData['data']);
            $scanner = new Scanner();

            $scanner->scanDirectory($pluginData->pluginPath);
            $scanner->searchFor(Scanner::CLASS_INSTANCE, "plugins\\Plugin");
            $pluginInstancePath = array_map(function ($data) {
                return $data["found"];
            }, $scanner->startScan()[$pluginData->pluginPath]["additional"])[0];
            $pluginInstancePath = ltrim($pluginInstancePath, '\\');
            $pluginManager = new PluginManager(new $pluginInstancePath());

            $pluginManager->installPlugin();

        }
        catch (\TypeError $e){
            echo $e->getMessage();
        }
        catch (\Exception $e){
            echo $e->getMessage();
        }

        return "true";
    }
    public function unInstall(){
        $pluginData = json_decode($this->postData['data']);
        $panels = new Panels(["panelId" => $pluginData->pluginId]);
        $pluginAdminInstance = $this->getPluginInstance();

        if(!$this->isInstanceOf($panels->getPluginInstance())) {
            $panels->remove();

            return "true";
        }
        else{
            return "false";
        }
    }
    public function getDialog(){
        $fileName = json_decode($this->postData['data'], true);
        $pluginInstance = $this->getPluginInstance();
        $pluginPath = $pluginInstance->pluginPath();

        return $this->pharseHTML($pluginPath.'/templates/dialogs/'.$fileName['fileName'].'.html.php', []);
    }
    private function getInstalledPlugins(){
        $nonInstalled = [];
        $scanner = new Scanner();
        $scanner->scanDirectory('plugins');
        $scanner->searchFor(Scanner::CLASS_INSTANCE, "plugins\\Plugin");
        $scanResults = $scanner->startScan();

        foreach ($scanResults as $directoryPath => $diretoryData){
            foreach ($diretoryData["additional"] as $existedPluginName){

                if(!empty($existedPluginName)){
                    $countPlugin = explode('\\', $existedPluginName['found']);
                    $pluginName = $countPlugin[sizeof($countPlugin)-1];
                    $pluginpath = strstr($existedPluginName['found'], $pluginName, true);
                    $plugins = new Panels(['pluginClassName' => $pluginName, 'pluginNameSpace' => rtrim(ltrim($pluginpath, '\\'), '\\')]);

                    if($plugins->getPluginInstance() === null){

                        $plugins->setPluginNameSpace(rtrim(ltrim($pluginpath, '\\'), '\\'));
                        $plugins->setPluginClassName($pluginName);
                        $plugins->setActive('Nie zainstalowany.');
                        $nonInstalled['nonInstalled'][] = serialize($plugins);

                    }
                }
            }
        }

        return $nonInstalled;
    }
    private function getExistedPlugins(){
        $existedPlugins = [];
        $queryBuilder = $this->queryBuilder();

        $queryBuilder->createQueryForTable('panels');
        $queryBuilder->selectData();
        $queryResults = $queryBuilder->execQuery()->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($queryResults as $panelRow){
            $plugins = new Panels(["panelId" => $panelRow["panelId"]]);
            $pluginOb = $plugins->getPluginInstance();

            if($pluginOb !== null) {
                if($plugins->getActive() === '1'){
                    $plugins->setActive(1); //Active
                    $existedPlugins['active'][] = serialize($plugins);
                }
                else if($plugins->getActive() !== '1'){
                    $plugins->setActive(2); //Disabled
                    $existedPlugins['nonActive'][] = serialize($plugins);
                }
            }
            else{
                $plugins->setPluginClassName($plugins->getPluginClassName());
                $plugins->setActive('Nie istnieje ale jest dostępny w bazie danych.');
                $existedPlugins['nonExisted'][] = serialize($plugins);
            }
        }
        return $existedPlugins;
    }
}