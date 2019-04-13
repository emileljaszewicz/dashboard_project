<?php
namespace plugins\userProfile\PluginControllers;

use plugins\PluginController;

class settingsController extends PluginController
{
    public function index(){
        $this->setPageTitle("Ustawienia profilu użytkownika");
        return $this->render('userProfileSettings');
    }
}