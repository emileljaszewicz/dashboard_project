<?php
namespace plugins\pluginsAdmin\classExtensions;


use library\HTTPMethodHandlerFilter;
use plugins\pluginsAdmin\PluginControllers\PluginsListController;

class PluginsListControllerExtension
{
    private $controller;
    private $recordsPerPage = 2;
    public function __construct(PluginsListController $controller)
    {
        $this->controller = $controller;

    }
    public function getActualPageData(){
        $httpFilter = new HTTPMethodHandlerFilter();
        $nextPageData = $httpFilter->setMethodsData([json_decode($this->controller->postData['otherData'], true), $_GET])->getData('nextPage');
        $currentPageNumber = (int)$nextPageData->getValues();
        $minRowsOffset = ($currentPageNumber > 0)? $currentPageNumber*$this->recordsPerPage : 0;
        return ['currentPage' => $currentPageNumber, 'minRowsOffset' => $minRowsOffset];
    }
    public function getPaginationData(){
        $paginationDetails = $this->getActualPageData();
        $pluginsTableRowCount = $this->controller->getData('allTableRows')['rowCount'];


        $pages = (($pluginsTableRowCount/$this->recordsPerPage) > 1 && $pluginsTableRowCount > $this->recordsPerPage)? ($pluginsTableRowCount/$this->recordsPerPage) : 0;

        return ['allPages' => $pages, 'currentPage' => $paginationDetails['currentPage'], 'rowsOffset' => $paginationDetails['minRowsOffset']];
    }
}