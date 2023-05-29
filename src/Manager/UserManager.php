<?php

namespace DaBuild\Manager;

use DaBuild\Entity\User;
use DaBuild\Repository\UserRepository;

class UserManager
{
    /**
     * @param string $password
     * @return string
     */
    public function hashUserPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param string $sMail
     * @param string $sPassword
     * @return User|null
     * @throws \Exception
     */
    public function authUser(string $sMail, string $sPassword): ?User
    {
        $aUserCriterias = ['email' => $sMail];


        $aUser = UserRepository::findBy($aUserCriterias);
        if (!empty($aUser)) {
            $oUser = $aUser[0];

            if ($oUser instanceof User && password_verify($sPassword, $oUser->getPassword())) {
                return $oUser;
            }
        }
        return NULL;
    }
}