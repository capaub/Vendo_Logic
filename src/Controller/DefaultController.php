<?php

namespace DaBuild\Controller;

use DaBuild\Repository\CustomerRepository;
use DaBuild\Repository\VendingPerCustomerRepository;
use DaBuild\Repository\VendingRepository;
use DaBuild\Repository\UserRepository;

class DefaultController extends AbstractController
{
    /**
     * @return string
     * @throws \Exception
     */
    public function showCustomers(): string
    {
        $aVending = [];

        $aCustomer = CustomerRepository::findAll();

        foreach ($aCustomer as $oCustomer) {

            $aVendingPerCustomerCriterias =
                [
                    'costumer_id' => $oCustomer->getId()
                ];

            $aCriterias = VendingPerCustomerRepository::buildCriterias($aVendingPerCustomerCriterias);
            $aVendingPerCustomer = VendingPerCustomerRepository::findBy($aCriterias);

            foreach ($aVendingPerCustomer as $oVendingPerCustomer) {

                $iCustomerId = $oVendingPerCustomer->getCustomerId();
                $iVendingId = $oVendingPerCustomer->getVendingId();
                $oVending = VendingRepository::find($iVendingId);


                    $aVending[$iCustomerId][$iVendingId] = $oVending;


            }

        }

        $bAjax = isset($_POST['context']);

        return $this->render('customers.php',
            [
                'seo_title' => PAGE_CUSTOMERS,
                'customer' => $aCustomer,
                'vending' => $aVending
            ],$bAjax);
    }

    public function pageAccount(): string
    {
        return $this->render('account.php',['user' => $_SESSION['user']]);
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function showVending()
    {

        return $this->render('vendings.php', [
            'seo_title' => PAGE_VENDINGS,
            'vending' => VendingRepository::findAll()
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function showUsers()
    {

        return $this->render('main/users/users.php', [
            'seo_title' => PAGE_USERS,
            'user' => UserRepository::findAll()
        ]);
    }


    /**
     * @return string
     */
    public function home(): string
    {
        return $this->render(
            'home.php',
            ['seo_title' => PAGE_HOME]
        );
    }


    /**
     * @return string
     */
    public function register(): string
    {
        return $this->render(
            'register.php',
            ['seo_title' => PAGE_REGISTER]
        );
    }

    /**
     * @return string
     */
    public function vending(): string
    {
        return $this->render(
            '_addVending.php',
            ['seo_title' => PAGE_ADD_VENDING]
        );
    }

    /**
     * @return string
     */
    public function vendingBuilder(): string
    {
        return $this->render(
            'vendingBuilder.php',
            ['seo_title' => PAGE_SAVE_VENDING]
        );
    }

}