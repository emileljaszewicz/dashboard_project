<?php
namespace controller;


use Entities\Users;
use userranks\Owner;

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


        if($users->getUserRankId()->getUserRankId() !== null){
            $sessionManager = $this->getSessionManager();
            $sessionManager->addSessionData('userId', $users->getUserId());
        }else{
            //$validator = $this->getValidator();
            $this->setError('loginError', "Nieprawidłowe dane");
            $this->setError('passwordError', "Nieprawidłowe dane");
        }

        $this->redirect('index.php');
    }

    private function setError($errorType, $errorMessage){
        $errors = [];
        $sessionManager = $this->getSessionManager();
        $errors[$errorType][] = $errorMessage;
        $sessionManager->addSessionData($errorType, $errors[$errorType]);
    }

    public function getErrors($errorType){
        $sessionManager = $this->getSessionManager();
        $err = $sessionManager->getSessionData($errorType);

        $sessionManager->remove($errorType);
        if(($err !== null)) {

            return implode(PHP_EOL, $err);
        }
        else{
            return null;
        }
    }
}