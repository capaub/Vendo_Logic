<?php

namespace DaBuild\Controller;

use DaBuild\Entity\Address;
use DaBuild\Entity\Company;
use DaBuild\Entity\User;
use DaBuild\Manager\UserManager;
use DaBuild\Repository\AddressRepository;
use DaBuild\Repository\CompanyRepository;
use DaBuild\Repository\UserRepository;

class CompanyController extends AbstractController
{
    /**
     * @return string
     */
    public function register(): string
    {
        if (isset(
                $_POST['field_company_name'],
                $_POST['field_siret'],
                $_POST['field_firstname'],
                $_POST['field_lastname'],
                $_POST['field_email'],
                $_POST['field_password'],
                $_POST['field_password_confirm'],
                $_POST['field_country'],
                $_POST['field_city'],
                $_POST['field_postal_code'],
                $_POST['field_street_name'])
        ) {
            $sCleanCompanyName = strip_tags($_POST['field_company_name']);
            $sCleanSiret = strip_tags($_POST['field_siret']);
            $sCleanFirstname = strip_tags($_POST['field_firstname']);
            $sCleanLastname = strip_tags($_POST['field_lastname']);
            $sCleanMail = filter_input(INPUT_POST, 'field_email', FILTER_SANITIZE_EMAIL);
            $sCleanPassword = strip_tags($_POST['field_password']);
            $sCleanPasswordConfirm = strip_tags($_POST['field_password_confirm']);
            $sCleanCountry = strip_tags($_POST['field_country']);
            $sCleanCity = strip_tags($_POST['field_city']);
            $sCleanPostalCode = strip_tags($_POST['field_postal_code']);
            $sCleanStreetName = strip_tags($_POST['field_street_name']);

            if (!CompanyRepository::isExist($sCleanSiret)) {
                if ($sCleanPassword === $sCleanPasswordConfirm) {

                    $oCompany = new Company($sCleanSiret, $sCleanCompanyName);

                    CompanyRepository::save($oCompany);

                    $_SESSION['company_id'] = $oCompany->getId();

                    $sHashedPassword = (new UserManager)->hashUserPassword($sCleanPassword);

                    $oAddress = new Address(
                        $sCleanCountry,
                        $sCleanCity,
                        $sCleanPostalCode,
                        $sCleanStreetName);

                    AddressRepository::save($oAddress);

                    $oUser = new User(
                        $sCleanFirstname,
                        $sCleanLastname,
                        $sCleanMail,
                        $_SESSION['company_id'],
                        $oAddress->getId(),
                        $sHashedPassword,
                        User::ROLE_ADMIN);

                    UserRepository::save($oUser);

//                    $_SESSION['user'] = $oUser;

                    $_SESSION['flashes'][] = ['SUCCESS' => 'Utilisateur créer avec succés'];

                    return $this->render('_login.php', [
                        'seo_title' => 'Connexion'
                    ]);

                } else {
                    $_SESSION['flashes'][] = ['ERREUR' => 'Mots de passe différents'];
                }
            } else {
                $_SESSION['flashes'][] = ['ERREUR' => 'Compte déjà existant'];
            }
        }
        return $this->render('register.php', [
            'seo_title' => 'Souscription'
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function createUser(): string
    {
        $bAjax = !empty($_POST['context']) ?? false;

        if (isset(
            $_POST['field_firstname'],
            $_POST['field_lastname'],
            $_POST['field_email'],
            $_POST['field_role']
        )) {
            $sCleanFirstname = strip_tags($_POST['field_firstname']);
            $sCleanLastname = strip_tags($_POST['field_lastname']);
            $sCleanMail = filter_input(INPUT_POST, 'field_email', FILTER_SANITIZE_EMAIL);
            $sCleanRole = intval(strip_tags($_POST['field_role']));

            if (CompanyRepository::isExist($_SESSION['user']->getCompanyId())
                && $_SESSION['user'] instanceof User
                && ($_SESSION['user']->getRole()) === User::ROLE_ADMIN) {

                if (!UserRepository::isExist($sCleanMail)) {

                    $oUser = new User(
                        $sCleanFirstname,
                        $sCleanLastname,
                        $sCleanMail,
                        $_SESSION['user']->getCompanyId(),
                        NULL,
                        NULL,
                        $sCleanRole);


                    UserRepository::save($oUser);

                    $sMessage = $oUser->getFirstname() . ', utilisateur créer avec succés';
                    $_SESSION['flashes'][] = ['SUCCESS' => $sMessage];



                    mail(
                        'capitone.aubry@gmail.com',
                        "Initialisation du compte",
                        "veuillez suivre ce lien pour créer votre mots de passe"
                    );

                    return $this->render('main/users/_users.php', [
                        'seo_title' => 'Utilisateurs',
                        'user' => UserRepository::findAll()
                    ],$bAjax);

                } else {
                    $_SESSION['flashes'][] = ['ERREUR' => 'Utilisateur déjà existant'];
                }
            } else {
                $_SESSION['flashes'][] = ['ERREUR' => 'Company inexistant'];
            }
        }
        return $this->render('main/users/_createUser.php', [
            'seo_title' => 'Création d\'un utilisateur',
        ],$bAjax);
    }


}