<?php

namespace DaBuild\Controller;

use DaBuild\Entity\User;
use DaBuild\Entity\Vending;
use DaBuild\Repository\BatchRepository;
use DaBuild\Repository\CompanyRepository;
use DaBuild\Repository\GoodsRepository;
use DaBuild\Repository\VendingLocationRepository;
use DaBuild\Repository\VendingRepository;
use DaBuild\Repository\VendingStockRepository;

class VendingController extends AbstractController
{
    /**
     * @return string
     */
    public function createVending(): string
    {
        $bAjax= !empty($_POST['context']) ?? false;

        if (!empty($_POST['field_brand'])
            && !empty($_POST['field_model'])
            && !empty($_POST['field_max_tray'])
            && !empty($_POST['field_max_spiral'])) {
            $sCleanBrand = strip_tags($_POST['field_brand']);
            $sCleanModel = strip_tags($_POST['field_model']);
            $sCleanMaxTray = intval(strip_tags($_POST['field_max_tray']));
            $sCleanMaxSpiral = intval(strip_tags($_POST['field_max_spiral']));

            if (CompanyRepository::isExist($_SESSION['user']->getCompanyId())
                && $_SESSION['user'] instanceof User
                && ($_SESSION['user']->getRole()) === User::ROLE_ADMIN) {

                $oVending = new Vending(
                    $sCleanBrand,
                    $sCleanModel,
                    $sCleanMaxTray,
                    $sCleanMaxSpiral,
                    $_SESSION['user']->getCompanyId());

                VendingRepository::save($oVending);

                $_SESSION['flashes'][] = ['SUCCESS' => ' Machine créer avec succés'];

                return $this->render('_vendings.php',
                    [
                        'seo_title' => 'Création d\'une machine',
                        'vending' => VendingRepository::findAll()
                    ], $bAjax);


            } else {
                $_SESSION['flashes'][] = ['ERREUR' => 'Company inexistant'];
            }
        }
        return $this->render('_vendings.php',
            [
                'seo_title' => 'Création d\'un utilisateur',
                'vending' => VendingRepository::findAll()
            ], $bAjax);
    }

    /**
     * @throws \Exception
     */
    public function buildVending(): string
    {
        $bAjax = !empty($_POST['context']) ?? false;
        if (!empty($_GET['vending_id'])) {

            $iCleanVendingId = intval(strip_tags($_GET['vending_id']));

            $oVending = VendingRepository::find($iCleanVendingId);

            $aVendingLocation = VendingLocationRepository::findAll();

            $aDataVendingLocation = [];

            foreach ($aVendingLocation as $oVendingLocation) {
                $aDataVendingLocation[$oVendingLocation->getLocation()] = $oVendingLocation->getId();
            }

            $aDataVendingStock = [];

            foreach ($aDataVendingLocation as $sLocation => $iVendingLocationId) {

                $aVendingStockCriterias = ['vending_location_id' => $iVendingLocationId];

                $aVendingStock = VendingStockRepository::findBy($aVendingStockCriterias);

                foreach ($aVendingStock as $oVendingStock) {

                    $oBatch = BatchRepository::find($oVendingStock->getBatchesId());
                    $oGoods = GoodsRepository::find($oBatch->getGoodsId());

                    $aLocationInfo = [
                        'batch_id' => $oBatch->getId(),
                        'dlc' => $oBatch->getDlc(),
                        'quantity' => $oVendingStock->getQuantity(),
                        'qr_code' => $oBatch->getQrCode(),
                        'barcode' => $oGoods->getBarcode(),
                        'brand' => $oGoods->getBrand(),
                        'img' => $oGoods->getImg(),
                        'nutri-score' => $oGoods->getNutriScore()
                    ];

                    $aDataVendingStock[$sLocation] =  $aLocationInfo;
                }
            }

            $sCleanVendingTags = isset($_GET['vending_tags']) ? strip_tags($_GET['vending_tags']) : '';

            return $this->render(

                'vendingByQrcode.php',
                [
                    'vendingTags'       => $sCleanVendingTags,
                    'dataVendingStock'  => $aDataVendingStock,
                    'vendingId'         => $oVending->getId(),
                    'nbVendingTray'     => $oVending->getNbMaxTray(),
                    'nbVendingSpiral'   => $oVending->getNbMaxSpiral()
                ]);
        }


        if (!empty($_POST['vending_id'])) {

            $iCleanVendingId = intval(strip_tags($_POST['vending_id']));

            $oVending = VendingRepository::find($iCleanVendingId);

            $aVendingLocation = VendingLocationRepository::findAll();

            $aDataVendingLocation = [];

            foreach ($aVendingLocation as $oVendingLocation) {
                $aDataVendingLocation[$oVendingLocation->getLocation()] = $oVendingLocation->getId();
            }

            $aDataVendingStock = [];

            foreach ($aDataVendingLocation as $sLocation => $iVendingLocationId) {

                $aVendingStockCriterias = ['vending_location_id' => $iVendingLocationId];

                $aVendingStock = VendingStockRepository::findBy($aVendingStockCriterias);

                foreach ($aVendingStock as $oVendingStock) {

                    $oBatch = BatchRepository::find($oVendingStock->getBatchesId());
                    $oGoods = GoodsRepository::find($oBatch->getGoodsId());

                    $aLocationInfo = [
                        'batch_id' => $oBatch->getId(),
                        'dlc' => $oBatch->getDlc(),
                        'quantity' => $oVendingStock->getQuantity(),
                        'qr_code' => $oBatch->getQrCode(),
                        'barcode' => $oGoods->getBarcode(),
                        'brand' => $oGoods->getBrand(),
                        'img' => $oGoods->getImg(),
                        'nutri-score' => $oGoods->getNutriScore()
                    ];

                    $aDataVendingStock[$sLocation] =  $aLocationInfo;
                }
            }

            $sCleanVendingTags = isset($_POST['vending_tags']) ? strip_tags($_POST['vending_tags']) : '';

            return $this->render(
                'vendingId.php',
                [
                    'vendingTags'       => $sCleanVendingTags,
                    'dataVendingStock'  => $aDataVendingStock,
                    'vendingId'         => $oVending->getId(),
                    'nbVendingTray'     => $oVending->getNbMaxTray(),
                    'nbVendingSpiral'   => $oVending->getNbMaxSpiral()
                ], $bAjax);
        }

        return $_SESSION['ERREUR'] = 'machine introuvable';

    }

    /**
     * @return string
     * @throws \Exception
     */
    public function showAvailableVending(): string
    {
        $aAvailableVending = VendingRepository::getAvailableVending();

        return $this->render('_addVendingToCustomer.php',
            [
                'availableVending' => $aAvailableVending,
                'customerId' => $_POST['customer_id'],
                'companyName' => $_POST['customer_company_name']
            ], true
        );
    }
}