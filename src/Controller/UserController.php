<?php

namespace DaBuild\Controller;

use DaBuild\Entity\User;
use DaBuild\Manager\DbManager;
use DaBuild\Manager\UserManager;
use DaBuild\Repository\CompanyRepository;
use DaBuild\Repository\UserRepository;
use function Composer\Autoload\includeFile;

class UserController extends AbstractController
{
    /**
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        $this->redirectAndDie('?page=' . PAGE_HOME);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function login(): string
    {
        $_SESSION['flashes'] = [];

        if (isset(
                $_POST['form_login'],
                $_POST['field_email'])
            && !empty($_POST['field_password'])) {

            $sCleanPassword = strip_tags($_POST['field_password']);
            $sCleanMail = filter_input(INPUT_POST, 'field_email', FILTER_SANITIZE_EMAIL);

            $oUser = (new UserManager)->authUser($sCleanMail, $sCleanPassword);

            if ($oUser instanceof User) {

                $aUserCriterias =
                    [
                        'id' => $oUser->getId(),
                        'connected_at' => (new \DateTime('now'))->format('Y-m-d H:i:s')
                    ];

                $aUpdateData = UserRepository::buildCriterias($aUserCriterias);

                $aUpdateData['where'] = str_replace(' WHERE ', ' ', $aUpdateData['where']);

                UserRepository::update($aUpdateData);

                $_SESSION['user'] = $oUser;
                $_SESSION['flashes'][] = ['SUCCESS' => 'Connexion'];

                return $this->render('home.php', [
                    'seo_title' => 'Bonjour' . $oUser->getFirstname()]);
            } else {
                $_SESSION['flashes'][] = ['DANGER' => 'identifiants invalide'];
            }


        } elseif (isset($_POST['form_login'], $_POST['field_email'])
            && empty($_POST['field_password'])
            && UserRepository::isExist($_POST['field_email'])) {

            $sCleanMail = strip_tags($_POST['field_email']);

            $aUserCriterias = ['email' => $sCleanMail];

            $aUser = UserRepository::findBy($aUserCriterias);

            $oUser = $aUser[0];

            if (is_null($oUser->getPassword())) {
                return $this->render('_createPassword.php', [
                    'seo_title' => 'Création du mdp',
                    'user' => $oUser]);
            }
        }

        return $this->render('_login.php',
            ['seo_title' => PAGE_HOME]);
    }


    /**
     * @return string|null
     */
    public function updateUser(): string|null
    {
//     if (empty($_SESSION['user']))   {
//         $this->redirectAndDie('?page='.PAGE_LOGIN);
//     }

        if (!empty($_POST['field_password']) && !empty($_POST['field_password_confirm'])) {

            $sHashpassword = (new UserManager)->hashUserPassword($_POST['field_password']);

            $aUserCriterias =
                [
                    'password'=>$sHashpassword,
                    'id' => $_POST['id']
                ];

            $aUpdateData = UserRepository::buildCriterias($aUserCriterias);
            UserRepository::update($aUpdateData);
            return $this->render('_login.php',bAjax: true);
        }

        $id = '';
        if (!empty($_SESSION['user'])) {
            $id = intval($_SESSION['user']->getId());
        }
        if (!empty($_GET['id'])) {
            $id = intval(strip_tags($_GET['id']));
        }
        if (!empty($_POST['id'])) {
            $id = intval(strip_tags($_POST['id']));
        }
        if (!empty($_POST['user_id'])) {
            $id = intval(strip_tags($_POST['user_id']));
        }
        if (!empty($_POST['data-user-id'])) {
            $id = intval(strip_tags($_POST['data-user-id']));
        }

        $aUserCriterias = [];

        foreach ($_POST as $key => $value) {
            $newKey = str_replace('field_', '', $key);
            $sCleanValue = strip_tags($value);

            $aUserCriterias[$newKey] = $sCleanValue;
        }

        $aUserCriterias['id'] = $id;

        $aUpdateData = UserRepository::buildCriterias($aUserCriterias);

        if (!empty($aUpdateData['where'])) {
            UserRepository::update($aUpdateData);
        }

        return null;

    }

    /**
     * @return string
     * @throws \Exception
     */
    public function refreshUser(): string
    {
        static::updateUser();

        $iCleanId = intval((strip_tags($_POST['user_id'])));

        return $this->render('main/users/user.php',
            [
                'seo_title' => 'coucou',
                'oUser' => UserRepository::find($iCleanId)
            ], true);
    }

    /**
     * @return string
     */
    public function deleteUser(): string
    {

        if (CompanyRepository::isExist($_SESSION['user']->getCompanyId())
            && $_SESSION['user'] instanceof User
            && ($_SESSION['user']->getRole()) === User::ROLE_ADMIN) {

            if (!UserRepository::isExist($_POST['user_id'])) {

                UserRepository::delete($_POST['user_id']);

                $_SESSION['flashes'][] = ['SUCCESS' => 'Utilisateur supprimé avec succés'];

                $this->redirectAndDie('?page=' . PAGE_USERS);

            } else {
                $_SESSION['flashes'][] = ['ERREUR' => 'utiliateur innexistant'];
            }
        } else {
            $_SESSION['flashes'][] = ['ERREUR' => 'Company inexistant'];
        }

        return $this->render('main/users/user.php', bAjax: true);
    }
}