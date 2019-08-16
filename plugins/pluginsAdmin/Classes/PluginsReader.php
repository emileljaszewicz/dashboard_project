<?php

namespace plugins\pluginsAdmin\Classes;


use Entities\Panels;
use library\ArrayCollection;
use library\QueryBuilder;
use library\Scanner;
use plugins\ClassExtender;

class PluginsReader
{
    private $minCountOfRows = 0;
    private $maxCountOfRows;
    private $arrayCollection = null;
    private $collectionOfPluginInstances = [];

    public function __construct()
    {
        $this->arrayCollection = new ArrayCollection();
    }

    public function getExistedPlugins()
    {


        $queryResults = $this->getInstalledPanelsList();
        foreach ($queryResults['returnedRows'] as $panelRow) {
            $dbEntityPanelInstance = $this->getPluginInstance(["panelId" => $panelRow["panelId"]]);

            if ($this->isInstalled($dbEntityPanelInstance)) {
                $this->getPluginListWithActivity($dbEntityPanelInstance);
            } else {
                $this->setPluginActivity(['description' => 'Nie istnieje ale jest dostępny w bazie danych.', 'activityGroupName' => 'nonExisted'], $dbEntityPanelInstance);
            }
        }

        return ['installedPanels' => $this->collectionOfPluginInstances, 'tableRowCount' => $queryResults['allTableRowsCount']];
    }

    public function getNonInstalledPanelsList()
    {
        $offset = 0;
        $nonInstalledPluginsCount = 0;
        $allSystemPlugins = $this->getSystemPlugins();
        foreach ($allSystemPlugins as $directoryPath => $directoryData) {
            foreach ($directoryData["additional"] as $existedPluginName) {

                if (!array_key_exists('found', (array)$existedPluginName))
                    continue;

                $pluginDirName = trim(ClassExtender::getClassDirectoryPath(current($existedPluginName), -1), '\\');
                $pluginName = ClassExtender::getClassInstanceName(ltrim(current($existedPluginName), '\\'));
                $pluginInstance = $this->getPluginInstance(['pluginClassName' => $pluginName, 'pluginNameSpace' => $pluginDirName]);

                if (!$this->isInstalled($pluginInstance)) {

                    if($offset >= $this->getMinRowsCount() && $offset < ($this->getMinRowsCount() + $this->getMaxRowsCount())) {
                        $pluginInstance->setPluginNameSpace($pluginDirName);
                        $pluginInstance->setPluginClassName($pluginName);

                        $this->setPluginActivity(['description' => 'Nie zainstalowany.', 'activityGroupName' => 'nonInstalled'], $pluginInstance);
                    }
                        $offset ++;
                    $nonInstalledPluginsCount++;
                }
            }
        }
        return ['installedPanels' => $this->collectionOfPluginInstances, 'tableRowCount' => $nonInstalledPluginsCount];
    }

    private function isInstalled($panelInstance)
    {
        if ($panelInstance->getPluginInstance() !== null) {
            return true;
        }
        return false;
    }

    private function getPluginListWithActivity($pluginInstance)
    {
        $pluginActive = $pluginInstance->getActive();
        if ($pluginActive == 1) {
            return $this->setPluginActivity(1, $pluginInstance);
        }
        return $this->setPluginActivity(0, $pluginInstance);
    }

    private function setPluginActivity($activityFlag, $pluginInstance)
    {
        $activityPluginsGroupName = $this->getPluginActivityGroup($activityFlag);//($activityFlag === 1)? 'active' : (is_string($activityFlag)? 'nonExisted' : 'nonactive');
        $pluginInstance->setActive((is_array($activityFlag) ? $activityPluginsGroupName['description'] : $activityFlag));

        return $this->addToCollection((is_array($activityFlag) ? $activityPluginsGroupName['activityGroupName'] : $activityFlag), $pluginInstance);
    }

    private function addToCollection($collectionName, $pluginInstance)
    {

        $this->collectionOfPluginInstances[$collectionName][] = $pluginInstance;

        return $this->collectionOfPluginInstances;
    }

    public function setMinRowsCount($minCountOfRows)
    {
        $this->minCountOfRows = $minCountOfRows;
    }

    public function setMaxRowsCount($maxCountOfRows)
    {
        $this->maxCountOfRows = $maxCountOfRows;
    }

    private function getPluginInstance($queryParams)
    {
        $plugins = new Panels($queryParams);

        return $plugins;
    }

    private function getMinRowsCount()
    {
        return $this->minCountOfRows;
    }

    private function getMaxRowsCount()
    {
        return $this->maxCountOfRows;
    }

    private function getInstalledPanelsList()
    {
        $queryBuilder = $this->getQueryBuilderInstance();

        $queryBuilder->createQueryForTable('panels');
        $queryBuilder->selectData(['SQL_CALC_FOUND_ROWS *']);
        $queryBuilder->limit($this->getMinRowsCount(), $this->getMaxRowsCount());
        $arrayOfEntityPanelRows = $queryBuilder->execQuery()->fetchAll(\PDO::FETCH_ASSOC);

        $queryBuilder->selectData(['FOUND_ROWS() as rowCount']);
        $countOfTableRows = $queryBuilder->execQuery()->fetch(\PDO::FETCH_ASSOC);
        return ['returnedRows' => $arrayOfEntityPanelRows, 'allTableRowsCount' => $countOfTableRows];
    }

    private function getPluginActivityGroup($activityFlag)
    {
        switch ($activityFlag) {
            case 1:
                return 'active';
                break;
            case 0:
                return 'nonactive';
                break;
            case is_array($activityFlag):

                if (array_key_exists('description', $activityFlag) && array_key_exists('activityGroupName', $activityFlag)) {
                    return ['description' => $activityFlag['description'], 'activityGroupName' => $activityFlag['activityGroupName']];
                }
                throw new \Exception('Expected "description" and "activityGroupName" key name');
                break;

        }
    }

    private function getQueryBuilderInstance()
    {
        return new QueryBuilder();
    }

    private function getSystemPlugins()
    {
        $scanner = new Scanner();
        $scanner->scanDirectory('plugins');
        $scanner->searchFor(Scanner::CLASS_INSTANCE, "plugins\\Plugin");

        $existedSystemPlugins = $scanner->startScan();

        return $existedSystemPlugins;
    }
}