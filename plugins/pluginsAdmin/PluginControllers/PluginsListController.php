<?php
namespace plugins\pluginsAdmin\PluginControllers;



use Entities\Panels;
use library\PluginManager;
use library\Scanner;
use plugins\ClassExtension;
use plugins\PluginController;
use plugins\pluginsAdmin\Classes\PluginsReader;

class PluginsListController extends PluginController
{

    public function index(){
        $this->setPageTitle('Zainstalowane pluginy');

        $pluginsReader = new PluginsReader();

        $pluginsReader->setMinRowsCount(ClassExtension::extendClass($this)->getActualPageData()['minRowsOffset']);
        $pluginsReader->setMaxRowsCount(2);
        $installedPlugins = $pluginsReader->getExistedPlugins();

        $this->setData('allTableRows', $installedPlugins['tableRowCount']);


        return $this->render('pluginList', [
            "paginationInfo" => ClassExtension::extendClass($this)->getPaginationData(),
            "stats" => $installedPlugins,
            "PluginInstance" => $this->getPluginInstance()]);
    }

    public function existedPlugins(){
        $this->setPageTitle('Lista niezainstalowanych pluginów');

        $pluginsReader = new PluginsReader();
        $pluginsReader->setMinRowsCount(ClassExtension::extendClass($this)->getActualPageData()['minRowsOffset']);
        $pluginsReader->setMaxRowsCount(2);
        $nonInstalledPlugins= $pluginsReader->getNonInstalledPanelsList();

        $this->setData('allTableRows', ['rowCount' => $nonInstalledPlugins['tableRowCount']]);


        return $this->render('pluginList', [
            "paginationInfo" => ClassExtension::extendClass($this)->getPaginationData(),
            "stats" => $nonInstalledPlugins,
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
}