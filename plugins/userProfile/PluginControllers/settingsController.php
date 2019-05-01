<?php
namespace plugins\userProfile\PluginControllers;

use plugins\PluginController;

class settingsController extends PluginController
{
    public function index(){

        $this->setPageTitle("Ustawienia profilu użytkownika");
        $this->appendHeaderScripts(["styles" => [], "scripts" => ["specialFormatFields.js","userProfile.js", "mainScripts.js"]]);

        return $this->render('userProfileSettings', ["user" => $this->getUser()->getUserObiect()]);
    }
    public function saveData(){
        $dbFields = [
            'uName' => 'userName',
            'login' => 'login',
            'newPassword' => 'password|md5',
            'uEmail' => 'email'
        ];
        $validateFilters = [
            'login' => 'required|min:6',
            'uName' => 'regex:/^[a-zA-Z]+$/',
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'passwordConfirm' => 'required|same:newPassword',
            'uEmail' => 'regex:/^([a-zA-Z0-9\.\-_]{3,})@([a-zA-Z0-9]){2,}\.([a-zA-Z]){2,}$/'
        ];

        $fieldsToValidate = [];
        $formValidation = [];
        $userObject = $this->getUser();
        $validator = $this->getValidator(["same" => ':attribute must be compared with previous password']);
        $jsonFormData = json_decode($this->postData['data']);
        $formValues = $jsonFormData->values;

        foreach ($formValues as $inputName => $value){

            $fieldsToValidate[$inputName] = $value;
            $formValidation[$inputName] = $validateFilters[$inputName];
        }
        if(in_array('oldPassword', array_keys($fieldsToValidate))){
            $fieldsToValidate['actualPassword'] = md5($fieldsToValidate['oldPassword']);
            $fieldsToValidate['oldPassword'] = $userObject->getUserObiect()->getPassword();
            $formValidation['oldPassword'] = 'same:actualPassword';
        }

        $validation = $validator->make($fieldsToValidate,$formValidation);
        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors();
            return $errors->firstOfAll();

        } else {
            $queryBuilder = $this->queryBuilder();
            $queryBuilder->createQueryForTable('users');
            $filteredPostData = array_filter($validation->getValidatedData(), function($postName) use ($dbFields) {
                return in_array($postName, array_keys($dbFields));
            }, ARRAY_FILTER_USE_KEY);

            foreach ($filteredPostData as $postName => $postValue){
                $fieldAction = explode("|", $dbFields[$postName]);

                if(count($fieldAction) > 1){

                    $queryBuilder->prepareData($fieldAction[0], $fieldAction[1]($postValue));
                }
                else {
                    $queryBuilder->prepareData($dbFields[$postName], $postValue);
                }
                unset($filteredPostData[$postName]);
            }
            $queryBuilder->updateData();
            $queryBuilder->where(['userId' => $userObject->getUserObiect()->getUserId()]);
            $queryBuilder->execQuery();

            return true;
        }
    }
}