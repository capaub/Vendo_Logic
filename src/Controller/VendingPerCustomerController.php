<?php

namespace DaBuild\Controller;

use DaBuild\Entity\Company;
use DaBuild\Entity\User;
use DaBuild\Entity\Vending;
use DaBuild\Entity\VendingPerCustomer;
use DaBuild\Repository\CompanyRepository;
use DaBuild\Repository\CustomerRepository;
use DaBuild\Repository\VendingPerCustomerRepository;
use DaBuild\Repository\VendingRepository;
use DaBuild\Services\ExternalQrCodeAPIService;

class VendingPerCustomerController extends AbstractController
{
    /**
     * @return ?string
     * @throws \Exception
     */
    public function addVendingToCustomer(): ?string
    {
        if (!empty($_POST['field_vending_id'])
            && !empty($_POST['field_vending_name'])) {

            $iCleanCustomerId = intval(strip_tags($_POST['customer_id']));
            $sCleanVendingId = strip_tags($_POST['field_vending_id']);
            $sCleanVendingName = strip_tags($_POST['field_vending_name']);

            if ($_SESSION['user'] instanceof User
                && $_SESSION['user']->getRole() === User::ROLE_ADMIN
                && CompanyRepository::isExist($_SESSION['user']->getCompanyId())) {

                $oVendingPerCustomer = new VendingPerCustomer(
                    intval($sCleanVendingId),
                    $iCleanCustomerId,
                VendingPerCustomer::ASSIGNED);

                VendingPerCustomerRepository::save($oVendingPerCustomer);

                $aData['customer_id'] = $iCleanCustomerId;
                $aData['vending_id'] = $sCleanVendingId;
                $aData['url']  = 'http://localhost/Vendo_Logic/public/?page=vending&vending_id='.$sCleanVendingId; //TODO à changer au passage sur hébergeur
                // au scanne du qr code je veux avoir la machine

                (new ExternalQrCodeAPIService)->generateQrCode($aData);

                $sFilenameQrCode = $iCleanCustomerId . $sCleanVendingId . '.jpg';

                $aVendingCriterias =
                    [
                      'id'      => intval($sCleanVendingId),
                      'name'    => $sCleanVendingName,
                      'qr_code' => $sFilenameQrCode
                    ];

                $aCriterias = VendingRepository::buildCriterias($aVendingCriterias);

               VendingRepository::update($aCriterias);

                $aVending = [];

               $bAjax = !empty($_POST['context']);

                $aVendingPerCustomerCriterias =
                    [
                        'costumer_id' => $iCleanCustomerId
                    ];

                $aCriterias = VendingPerCustomerRepository::buildCriterias($aVendingPerCustomerCriterias);
                $aVendingPerCustomer = VendingPerCustomerRepository::findBy($aCriterias);

                foreach ($aVendingPerCustomer as $oVendingPerCustomer) {

                    $iCustomerId = $oVendingPerCustomer->getCustomerId();
                    $iVendingId = $oVendingPerCustomer->getVendingId();
                    $oVending = VendingRepository::find($iVendingId);


                    $aVending[$iCustomerId][$iVendingId] = $oVending;


                }
               return $this->render('_customers.php',
                   [
                       'customer' => [CustomerRepository::find($iCleanCustomerId)],
                       'vending' => $aVending
                   ],$bAjax);

            }
        }
        return null;
    }


}