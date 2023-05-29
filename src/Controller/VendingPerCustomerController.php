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
                $aData['url']  = 'https://acdigitalsolutions.fr/Vendo_Logic/public/?page=vending&vending_id='.$sCleanVendingId;
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

               return $this->render('customers',
                   [
                       'customer' => [CustomerRepository::find($iCleanCustomerId)]
                   ],true);

            }
        }
        return null;
    }


}