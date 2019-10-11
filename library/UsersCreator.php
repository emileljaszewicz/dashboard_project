<?php
namespace library;


use Entities\Userranks;
use Entities\Users;

class UsersCreator extends QueryBuilder
{
    private $userData;
    public function findUser(array $arrayData){
        $this->createQueryForTable('users');
        $this->selectData();
        $this->where($arrayData);
        $this->userData = $this->execQuery()->fetch(\PDO::FETCH_ASSOC);

        return $this->userData;
    }

    /**
     * @return Users
     * @throws \Exception
     */
    public function getUserObiect(){
        $pdoData = $this->userData;

        return new Users(['userId' => $pdoData['userId']]);
    }
    public function getUserRankObject(){
        $pdoData = $this->userData;
        $userRanks = new Userranks(["userRankId" => $pdoData['userRankId']]);

        if($userRanks->getRankName() !== null) {
            $userRankName = "\\userranks\\".$userRanks->getRankName();
            $userRankObject = new $userRankName();
            return $userRankObject;
        }
        else{
            return new \userranks\Owner();
        }
    }

    /**
     * @return Users
     * @throws \Exception
     */
    public static function createFromSession(){
        $sessionManager = new SessionManager();
        $user = new Users(['userId' => $sessionManager->getSessionData('userId')]);
        return $user;
    }
}