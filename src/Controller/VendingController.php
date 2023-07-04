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
     * @throws \Exception
     */
    public function createVending(): string
    {
        $bAjax = !empty($_POST['context']) ?? false;

        if (!empty($_POST['field_brand'])
            && !empty($_POST['field_model'])
            && !empty($_POST['field_max_tray'])
            && !empty($_POST['field_max_spiral'])) {
            $sCleanBrand = strip_tags($_POST['field_brand']);
            $sCleanModel = strip_tags($_POST['field_model']);
            $sCleanMaxTray = intval(strip_tags($_POST['field_max_tray'])); //TODO preg_match()
            $sCleanMaxSpiral = intval(strip_tags($_POST['field_max_spiral'])); //TODO preg_match()

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
     * @return string
     * @throws \Exception
     */
    public function buildVending(): string
    {
        $bAjax = !empty($_POST['context']) ?? false;

        $vendingId = $_GET['vending_id'] ?? $_POST['vending_id'] ?? null;
        $vendingTags = strip_tags($_GET['vending_tags'] ?? $_POST['vending_tags'] ?? '');

        if (!empty($vendingId) && VendingRepository::isExist($vendingId)) {
            $iCleanVendingId = intval(strip_tags($vendingId));
            $aDataVendingStock = self::getVendingData($iCleanVendingId);
            $oVending = VendingRepository::find($iCleanVendingId);
            $sView = !empty($_POST['vending_id']) ? 'vendingId.php' : 'vendingByQrcode.php';

            return $this->render(
                $sView,
                [
                    'vendingTags'       => $vendingTags,
                    'dataVendingStock'  => $aDataVendingStock,
                    'vendingId'         => $oVending->getId(),
                    'nbVendingTray'     => $oVending->getNbMaxTray(),
                    'nbVendingSpiral'   => $oVending->getNbMaxSpiral()
                ], $bAjax);
        }
        return $this->render('home');
    }

    /**
     * @param $iCleanVendingId
     * @return array
     * @throws \Exception
     */
    private static function getVendingData($iCleanVendingId): array
    {
        $aVendingLocation = VendingLocationRepository::findAllForOne($iCleanVendingId);

        $aDataVendingLocation = [];
        foreach ($aVendingLocation as $oVendingLocation) {
            $aDataVendingLocation[$oVendingLocation->getLocation()] = $oVendingLocation->getId();
        }

        $aDataVendingStock = [];
        foreach ($aDataVendingLocation as $sLocation => $iVendingLocationId) {
            $aVendingStockCriterias = ['vending_location_id' => $iVendingLocationId];
            $aVendingStock = VendingStockRepository::findBy($aVendingStockCriterias);
            foreach ($aVendingStock as $oVendingStock) {
                $oBatch = BatchRepository::find($oVendingStock->getBatchId());
                $oGoods = GoodsRepository::find($oBatch->getGoodsId());
                $aLocationInfo = [
                    'batch_id'      => $oBatch->getId(),
                    'dlc'           => $oBatch->getDlc(),
                    'qr_code'       => $oBatch->getQrCode(),
                    'quantity'      => $oVendingStock->getQuantity(),
                    'barcode'       => $oGoods->getBarcode(),
                    'brand'         => $oGoods->getBrand(),
                    'img'           => $oGoods->getImg(),
                    'nutri-score'   => $oGoods->getNutriScore()
                ];
                $aDataVendingStock[$sLocation] = $aLocationInfo;
            }
        }

        return $aDataVendingStock;
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