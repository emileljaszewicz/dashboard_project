<?php
namespace controller;


use Entities\Userranks;
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

    public function register(){

        $this->setPageTitle("Zaloguj się");
        $this->appendHeaderScripts(["scripts" => ['js/loginPanel.js']]);
        return $this->render('registerForm');
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
            $validator = $this->getValidator(['required' => 'The field can not be empty', 'min' => 'Minimum length of characters is 6']);
            $validation = $validator->make($_POST,[
               'uLogin' => 'required',
               'uPassword' => 'required|min:6'
            ]);
            $validation->validate();
            if($validation->fails()) {
                $errors = $validation->errors();

                foreach ($errors->firstOfAll() as $error => $errorMessage) {
                    $this->setMessage($error . 'Error', $errorMessage);
                }
            }
            else{
                $this->setMessage('otherErrors', "Incorrect login data");
            }

        }

        $this->redirect('index.php');
    }

    /**
     * @Privileges(isMethod(POST))
     * @SkipSearching(skip(true))
     */
    public function registerInit(){

        $validator = $this->getValidator(['required' => 'The field can not be empty', 'min' => 'Minimum length of characters is 6']);
        $validation = $validator->make($_POST,[
            'uLogin' => 'required',
            'uEmail' => 'required|regex:/^([a-zA-Z0-9\.\-_]{3,})@([a-zA-Z0-9]){2,}\.([a-zA-Z]){2,}$/',
            'uPassword' => 'required|min:6',
            'uConfirm' => 'required|same:uPassword',
        ]);
        $validation->validate();
        if($validation->fails()) {
            $errors = $validation->errors();

            foreach ($errors->firstOfAll() as $error => $errorMessage) {
                $this->setMessage($error . 'Error', $errorMessage);
            }
            return $this->redirect('index.php?task=index&action=register');
        }
        else{
            $users = new Users();

            if(in_array($result = $this->postData['uLogin'], $users->getLogin()) || in_array($result = $this->postData['uEmail'], $users->getEmail())){
                $errorFieldName = array_flip($this->postData)[$result];
                $this->setMessage($errorFieldName . 'Error', "Current ".ltrim(strtolower($errorFieldName), 'u')." ($result) already exists");
            }
            else {
                $userRanks = new Userranks(['rankName' => 'PanelsUser']);
                $rankId = $userRanks->getUserRankId();
                $users->setLogin($this->postData['uLogin']);
                $users->setPassword(md5($this->postData['uPassword']));
                $users->setEmail($this->postData['uEmail']);
                $users->setActive(1);
                $users->setUserRankId($rankId);
                $users->save();
                $this->setMessage('successMessages', 'On your email address has been sent confirmation email. Please confirm your registration and log in to page');

                return $this->redirect('index.php?task=index&action=login');
            }
            return $this->redirect('index.php?task=index&action=register');
        }
    }

}