<?php

namespace DaBuild\Controller;


use DaBuild\Repository\BatchRepository;
use DaBuild\Repository\GoodsRepository;
use DaBuild\Services\ExternalOpenFoodFactAPIService;
use Psr\SimpleCache\InvalidArgumentException;

class BatchController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function getAllBatch(): string
    {
        return $this->render('_addBatchesToVending.php',
            [
                'batch' => BatchRepository::findAll()
            ],
            true);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getBatchDataChangeAjax(): string
    {
        $iCleanBatchId = intval(strip_tags($_POST['batch_id']));
        $oBatch = BatchRepository::find($iCleanBatchId);

        $aSelectedBatch =
            [
                'quantity'        => $oBatch->getQuantity(),
                'updated_at_date' => $oBatch->getUpdatedAt()->format('d-m-Y') ?? '',
                'updated_at_time' => $oBatch->getUpdatedAt()->format('H:i:s') ?? ''
            ];

        header('Content-Type: application/json');

        return json_encode($aSelectedBatch);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getStockInfo(): string
    {
        $bAjax = !empty($_POST['context']) ?? false;

        $aBatch = BatchRepository::findAll();


        $aBatchInfo = [];

        foreach ($aBatch as $oBatch) {

            $oGoods = GoodsRepository::find($oBatch->getGoodsId());

            $aBatchInfo[$oBatch->getId()] =
                [
                    'dlc' => $oBatch->getDlc()->format('d-m-Y'),
                    'qr_code' => $oBatch->getQrCode(),
                    'quantity' => $oBatch->getQuantity(),
                    'created_at' => $oBatch->getCreatedAt()->format('d-m-Y'),
                    'updated_at_date' => $oBatch->getUpdatedAt()->format('d-m-Y') ?? '',
                    'updated_at_time' => $oBatch->getUpdatedAt()->format('H:i:s') ?? '',
                    'sold_out_at' => $oBatch->getSoldOutAt()->format('d-m-Y') ?? '',
                    'brand' => $oGoods->getBrand(),
                    'img' => $oGoods->getImg(),
                    'barcode' => $oGoods->getBarcode()
                ];
        }


        $aPooledDataForBatch = [];

        foreach ($aBatchInfo as $iBatchId => $aData) {

            if (isset($aPooledDataForBatch[$aData['barcode']])) {
                $aPooledDataForBatch[$aData['barcode']][$iBatchId] = $aData;
            } else {
                $aPooledDataForBatch[$aData['barcode']] = [$iBatchId => $aData];
            }

        }

        $aDataToRender = $aPooledDataForBatch;

        foreach ($aDataToRender as &$aGoods) {
            $aGoods['selectBatch'] = (count($aGoods) > 1);
            $aGoods['batchOptions'] = [];

            foreach ($aGoods as $iBatchId => $aData) {
                if ($iBatchId !== 'selectBatch' && $iBatchId !== 'batchOptions') {
                    $aGoods[$iBatchId] = $aData; // Ajoute chaque lot à $aGoods

                    if ($aGoods['selectBatch']) {
                        $aGoods['batchOptions'][$iBatchId] = $aData['dlc']; // Ajoute l'option du lot à batchOptions
                    } else {
                        unset($aGoods['batchOptions']); // Supprime le tableau batchOptions si selectBatch est false
                    }
                }
            }
        }

        return $this->render('stock.php', [
            'seo_title' => PAGE_STOCK,
            'dataToRender' => $aDataToRender], $bAjax);
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function createBatch(): string
    {
        if (!isset($_POST['barcode'])) {
            return $this->getStockInfo();
        }

        $sCleanBarcode = strip_tags($_POST['barcode']);

        try {
            $oProductDetails = ExternalOpenFoodFactAPIService::findProductAPI($sCleanBarcode);
        } catch (\Throwable $exception) {
            $_SESSION['flashes'] = ['ERROR' => $exception->getMessage()];
            return $this->getStockInfo();
        }

        if (!GoodsRepository::isExist($oProductDetails['_id'])) {
            (new GoodsController)->createGoods($oProductDetails);
        }

        $oGoods = GoodsRepository::getGoodsByBarcode($oProductDetails['_id']);
        $iCompanyId = $oGoods->getCompanyId(); // $_SESSION['user']->getCompanyId()
        $iGoodsId = $oGoods->getId();

        $sCleanDlc = strip_tags($_POST['dlc']);
        $iCleanQuantity = intval(strip_tags($_POST['quantity']));

        $iBatchId = BatchRepository::isCombinationExist($sCleanDlc, $iGoodsId);

        if ($iBatchId !== null) {
            $oBatch = BatchRepository::find($iBatchId);
            $iBatchId = $oBatch->getId();
            $iCleanQuantity = $oBatch->getQuantity() + $iCleanQuantity;

            $aUpdateData = [
                'id' => $iBatchId,
                'dlc' => $sCleanDlc,
                'quantity' => $iCleanQuantity
            ];

            BatchRepository::update(BatchRepository::buildCriterias($aUpdateData));
        } else {
            $sTpsFilePathQrCode = BatchRepository::generateTempQrCodeForBatch($iCompanyId, $iGoodsId, $sCleanDlc, $iCleanQuantity);
            $oBatch = BatchRepository::createNewBatch($sCleanDlc, $iCleanQuantity, $sTpsFilePathQrCode, $iGoodsId);
            $sFilenameQrCode = BatchRepository::generateQrCodeForBatch($iCompanyId, $oBatch);
            BatchRepository::updateBatchQrCode($oBatch, $sFilenameQrCode);

            if (file_exists($sTpsFilePathQrCode)) {
                if (unlink($sTpsFilePathQrCode)) {
                    $_SESSION['flashes'] = ['SUCCES' => 'Le fichier a été supprimé avec succès.'];
                } else {
                    $_SESSION['flashes'] = ['ERREUR' => 'Une erreur s\'est produite lors de la suppression du fichier.'];
                }
            } else {
                $_SESSION['flashes'] = ['WARNING' => 'Le fichier n\'existe pas.'];
            }
        }

        return $this->getStockInfo();
    }
}