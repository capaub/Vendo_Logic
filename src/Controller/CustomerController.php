<?php

namespace DaBuild\Controller;

use DaBuild\Entity\Address;
use DaBuild\Entity\Customer;
use DaBuild\Entity\User;
use DaBuild\Entity\VendingPerCustomer;
use DaBuild\Repository\AddressRepository;
use DaBuild\Repository\CompanyRepository;
use DaBuild\Repository\CustomerRepository;

class CustomerController extends AbstractController
{
    /**
     * @return string
     * @throws \Exception
     */
    public function addCustomer() : string
    {

        if (!empty($_POST['field_company_siret'])
            && !empty($_POST['field_company_name'])
            && !empty($_POST['field_country'])
            && !empty($_POST['field_city'])
            && !empty($_POST['field_postal_code'])
            && !empty($_POST['field_street_name'])
            && !empty($_POST['field_email'])
            && !empty($_POST['field_phone'])
            && !empty($_POST['field_firstname'])
            && !empty($_POST['field_lastname'])
        ) {
            if ($_SESSION['user'] instanceof User
                && $_SESSION['user']->getRole() === User::ROLE_ADMIN){

                $sCleanCompanySiret      = strip_tags($_POST['field_company_siret']);
                $sCleanCompanyName       = strip_tags($_POST['field_company_name']);
                $sCleanPostalCode        = strip_tags($_POST['field_postal_code']);
                $sCleanEmail             = strip_tags($_POST['field_email']);
                $sCleanPhone             = strip_tags($_POST['field_phone']);
                $sCleanFirstname         = strip_tags($_POST['field_firstname']);
                $sCleanLastname          = strip_tags($_POST['field_lastname']);
                $sCleanStreetName        = strip_tags($_POST['field_street_name']);
                $sCleanCountry           = strip_tags($_POST['field_country']);
                $sCleanCity              = strip_tags($_POST['field_city']);

                $oAddress = new Address(
                    $sCleanCountry,
                    $sCleanCity,
                    $sCleanPostalCode,
                    $sCleanStreetName);

                AddressRepository::save($oAddress);

                $oCustomer = new Customer(
                    $sCleanCompanySiret,
                    $sCleanCompanyName,
                    $sCleanEmail,
                    $sCleanPhone,
                    $sCleanFirstname,
                    $sCleanLastname,
                    $oAddress->getId(),
                    $_SESSION['user']->getCompanyId());

                CustomerRepository::save($oCustomer);

                $_SESSION['flashes'][] = ['SUCCESS' => 'Client créer avec succés'];

                return (new DefaultController)->showCustomers();

            } else {
                $_SESSION['flashes'][] = ['ERREUR' => 'Company inexistant ou user non-admin'];
            }
        }
        $bAjax = !empty($_POST['context']);
        return $this->render('_addCustomer.php', [
            'seo_title' => 'Création d\'un client'
        ], $bAjax);
    }
}