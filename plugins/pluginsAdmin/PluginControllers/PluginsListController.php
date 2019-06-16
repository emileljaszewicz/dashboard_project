<?php
namespace plugins\pluginsAdmin\PluginControllers;



use Entities\Panels;
use library\PluginManager;
use library\Scanner;
use plugins\PluginController;

class PluginsListController extends PluginController
{
    private $panels = [];

    public function index(){
        $this->setPageTitle('Zainstalowane pluginy');
        $paginationData = $this->getExistedPlugins()->setPagination();

        return $this->render('pluginList', [
            "stats" => $paginationData,
            "PluginInstance" => $this->getPluginInstance()]);
    }
    public function existedPlugins(){
        $this->setPageTitle('Lista niezainstalowanych pluginów');
        $paginationData = $this->getInstalledPlugins()->setPagination();


        return $this->render('pluginList', [
            "stats" => $paginationData,
            "PluginInstance" => $this->getPluginInstance()]);
    }

    public function enable(){
        $pluginData = json_decode($this->postData['data']);
        $panels = new Panels(["panelId" => $pluginData->pluginId]);

        if($panels->getPanelId() !== null) {
            $panels->setActive(1);

            if ($panels->save()) {
                return 'true';
            }
            else{
                return 'Can`t continue executing this action';
            }
        }
        else{
            return 'false';
        }
    }
    public function disable(){
        $pluginData = json_decode($this->postData['data']);
        $panels = new Panels(["panelId" => $pluginData->pluginId]);

        if(!$this->isInstanceOf($panels->getPluginInstance()) && ($panels->getPanelId() !== null)) {
            $panels->setActive(0);

            if ($panels->save()) {
                return 'true';
            }
            else{
                return 'Can`t continue executing this action';
            }
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
            $scanResults =  (!empty( $existedPlugins = $scanner->startScan())?$existedPlugins[$pluginData->pluginPath]["additional"]: false);
            if($scanResults) {
                $pluginInstancePath = array_map(function ($data) {
                    return $data["found"];
                }, $scanResults)[0];
                $pluginInstancePath = ltrim($pluginInstancePath, '\\');
                $pluginManager = new PluginManager(new $pluginInstancePath());

                $pluginManager->installPlugin();

                return "true";
            }
        }
        catch (\TypeError $e){
            echo $e->getMessage();
        }
        catch (\Exception $e){
            echo $e->getMessage();
        }

        return "false";
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
    private function getInstalledPlugins($minIndex = 0, $maxIndex = 9999){
        $elements = 0;
        $i = 0;
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
                        if($i >= $minIndex && $i < $minIndex+$maxIndex) {
                           $plugins->setPluginNameSpace(rtrim(ltrim($pluginpath, '\\'), '\\'));
                           $plugins->setPluginClassName($pluginName);
                           $plugins->setActive('Nie zainstalowany.');
                           $nonInstalled['nonInstalled'][] = $plugins;
                            $elements++;
                       }
                        $i++;
                    }
                }
            }
        }
        $this->panels = ['elements'=>serialize($nonInstalled), 'methodName' => __METHOD__, 'pluginsCount' => $elements];
       // return $nonInstalled;
        return $this;
    }
    private function getExistedPlugins($min = 0, $max=9999){
        $elements = 0;
        $existedPlugins = [];
        $queryBuilder = $this->queryBuilder();

        $queryBuilder->createQueryForTable('panels');
        $queryBuilder->selectData();
        $queryBuilder->limit($min,$max);


        $queryResults = $queryBuilder->execQuery()->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($queryResults as $panelRow){
            $plugins = new Panels(["panelId" => $panelRow["panelId"]]);
            $pluginOb = $plugins->getPluginInstance();

            if($pluginOb !== null) {
                if($plugins->getActive() === '1'){
                    $plugins->setActive(1); //Active
                    $existedPlugins['active'][] = $plugins;
                    $elements++;
                }
                else if($plugins->getActive() !== '1'){
                    $plugins->setActive(2); //Disabled
                    $existedPlugins['nonActive'][] = $plugins;
                    $elements++;
                }
            }
            else{
                $plugins->setPluginClassName($plugins->getPluginClassName());
                $plugins->setActive('Nie istnieje ale jest dostępny w bazie danych.');
                $existedPlugins['nonExisted'][] = $plugins;
                $elements++;
            }
        }

        $this->panels = ['elements'=>serialize($existedPlugins), 'methodName' => __METHOD__, 'pluginsCount' => $elements];
        return $this;
    }
    private function setPagination(){
        $httpFilter = $this->getHttpMethodFilter();
        $nextPageData = $httpFilter->setMethodsData([json_decode($this->postData['otherData'], true), $_GET])->getData('nextPage');
        $nextPageNumber = (int)$nextPageData->getValues();
        $recordsPerPage = 2;
        $minRowsOffset = ($nextPageNumber > 0)? $nextPageNumber*$recordsPerPage : 0;

        $pages = (($this->panels['pluginsCount']/$recordsPerPage) > 1 && $this->panels['pluginsCount'] > $recordsPerPage)? ($this->panels['pluginsCount']/$recordsPerPage) : 0;

        call_user_func_array($this->panels['methodName'], [$minRowsOffset, $recordsPerPage]);
        $this->panels['pages'] = $pages;
        $this->panels['currentPage'] = $nextPageNumber;

       return $this->panels;
    }
}