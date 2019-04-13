<?php
namespace controller;


use Entities\Users;

/**
 * @Privileges(isUnlogged(user))
 */
class indexController extends Controller
{

    public function login(){
        $this->setPageTitle("Zaloguj się");
        $this->appendHeaderScripts(["scripts" => ['js/loginPanel.js']]);
        return $this->render('loginForm');
    }

    /**
     * @Privileges(isMethod(POST))
     * @SkipSearching(skip(true))
     */
    public function userInit(){

       $users = new Users(['login' => $this->postData['uLogin'], 'password' => md5($this->postData['uPassword'])]);

        if($users->getUserRankId() !== null){
            $sessionManager = $this->getSessionManager();
            $sessionManager->addSessionData('userId', $users->getUserId());
        }

        $this->redirect('index.php');
    }
}