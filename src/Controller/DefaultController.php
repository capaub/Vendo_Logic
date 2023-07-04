<?php

namespace DaBuild\Controller;

use DaBuild\Repository\BatchRepository;
use DaBuild\Repository\CustomerRepository;
use DaBuild\Repository\GoodsRepository;
use DaBuild\Repository\VendingLocationRepository;
use DaBuild\Repository\VendingPerCustomerRepository;
use DaBuild\Repository\VendingRepository;
use DaBuild\Repository\UserRepository;
use DaBuild\Repository\VendingStockRepository;

class DefaultController extends AbstractController
{
    /**
     * @return string
     * @throws \Exception
     */
    public function showCustomers(): string
    {
        $aVending = [];
        $aVendingAlert = [];
        $aCustomerAlert = [];

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

                $aVendingLocation = VendingLocationRepository::findAllForOne($iVendingId);
                foreach ($aVendingLocation as $oVendingLocation) {
                    $aVendingStock = VendingStockRepository::findBy(['vending_location_id' => $oVendingLocation->getId()]);

                    $iBatchId = $aVendingStock != null ? $aVendingStock[0]->getBatchId() : '';
                    $oBatch = BatchRepository::find(intval($iBatchId));

                    if ($oBatch !== NULL && ($oBatch->getDlc() < (new \DateTime(DLC_TIMEOUT_ALERT)))) {
                        if (empty($aVendingAlert[$iVendingId])) {
                            $aVendingAlert[$iVendingId] = 'dlc';
                        } elseif ($aVendingAlert[$iVendingId] === 'rupture') {
                            $aVendingAlert[$iVendingId] .= ' dlc';
                        }
                    }

                    if ($aVendingStock == null || ($aVendingStock[0]->getQuantity() < QUANTITY_LIMIT_ALERT)) {
                        if (empty($aVendingAlert[$iVendingId])) {
                            $aVendingAlert[$iVendingId] = 'rupture';
                        } elseif ($aVendingAlert[$iVendingId] === 'dlc') {
                            $aVendingAlert[$iVendingId] .= ' rupture';
                        }
                    }
                }
                if (!empty($aVendingAlert[$iVendingId])) {
                    $aCustomerAlert[$iCustomerId] = 'alert';
                }
            }

        }

        $bAjax = !empty($_POST['context']);

        return $this->render('customers.php',
            [
                'seo_title' => PAGE_CUSTOMERS,
                'customer' => $aCustomer,
                'vending' => $aVending,
                'status' => $aVendingAlert,
                'customerStatus' => $aCustomerAlert,
            ], $bAjax);
    }

    public function pageAccount(): string
    {
        return $this->render('account.php', ['user' => $_SESSION['user']]);
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
}