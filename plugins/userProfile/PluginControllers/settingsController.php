<?php
namespace plugins\userProfile\PluginControllers;

use plugins\PluginController;

class settingsController extends PluginController
{
    private $rules_for_post_name = [];
    private $post_data_db_mapping;

    public function __construct()
    {
        parent::__construct();
        $this->rules_for_post_name = [
            'login' => 'required|min:6',
            'uName' => 'regex:/^[a-zA-Z]+$/',
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'passwordConfirm' => 'required|same:newPassword',
            'uEmail' => 'regex:/^([a-zA-Z0-9\.\-_]{3,})@([a-zA-Z0-9]){2,}\.([a-zA-Z]){2,}$/'
        ];
        $this->post_data_db_mapping = [
            'uName' => 'userName',
            'login' => 'login',
            'newPassword' => ['password', function($currentPostElement){
                $postValue = current(array_values($currentPostElement));

                return md5($postValue);
            }],
            'uEmail' => 'email'
        ];
    }

    public function index(){

        $this->setPageTitle("Ustawienia profilu użytkownika");
        $this->appendHeaderScripts(["styles" => [], "scripts" => ["specialFormatFields.js","userProfile.js", "mainScripts.js"]]);

        return $this->render('userProfileSettings', ["user" => $this->getUser()->getUserObiect()]);
    }

    public function saveData(){
        $validator = $this->getValidator(["same" => ':attribute must be compared with previous password']);

        $jsonFormData = json_decode($this->postData['data'], true);
        $validationRules = $this->getValidationRulesFromPostData($jsonFormData['formValues']);

        $validation = $validator->make($validationRules['filteredPostData'],$validationRules['rulesForPostData']);
        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors();
            return $errors->firstOfAll();

        } else {

            $this->saveValidatedData($validationRules['filteredPostData']);

            return true;
        }
    }

    private function getValidationRulesFromPostData(array $postData){
        $userObject = $this->getUser();
        $formValidation = [];
        $fieldsToValidate = [];
        
        foreach ($postData as $inputName => $value){
            if(!array_key_exists($inputName,$this->rules_for_post_name) )
                continue;

            $fieldsToValidate[$inputName] = $value;
            $formValidation[$inputName] = $this->rules_for_post_name[$inputName];
        }

        if(in_array('oldPassword', array_keys($fieldsToValidate))){
            $fieldsToValidate['actualPassword'] = md5($fieldsToValidate['oldPassword']);
            $fieldsToValidate['oldPassword'] = $userObject->getUserObiect()->getPassword();
            $formValidation['oldPassword'] = 'same:actualPassword';
        }
        
        return ['filteredPostData' => $fieldsToValidate, 'rulesForPostData' => $formValidation];
    }

    private function saveValidatedData(array $postData){
        $userObject = $this->getUser();
        $queryBuilder = $this->queryBuilder();
        $queryBuilder->createQueryForTable('users');

        foreach ($postData as $postName => $postValue){
            if(!array_key_exists($postName,$this->post_data_db_mapping) )
                continue;

            $mappingDataToSave = $this->post_data_db_mapping[$postName];
            if(is_array($mappingDataToSave) && is_callable(end($mappingDataToSave))){
                $mappedDbFieldName = reset($mappingDataToSave);
                $queryBuilder->prepareData($mappedDbFieldName, $this->formatPostData([$postName => $postValue], end($mappingDataToSave)));
            }
            else {
                $queryBuilder->prepareData($mappingDataToSave, $postValue);
            }
        }
        $queryBuilder->updateData();
        $queryBuilder->where(['userId' => $userObject->getUserObiect()->getUserId()]);
        $queryBuilder->execQuery();
    }

    private function formatPostData($postData, callable $functionForPostData){
        return call_user_func_array($functionForPostData, [$postData]);
    }
}