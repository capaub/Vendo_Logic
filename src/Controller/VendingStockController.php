<?php

namespace DaBuild\Controller;

use DaBuild\Entity\VendingLocation;
use DaBuild\Entity\VendingStock;
use DaBuild\Repository\VendingLocationRepository;
use DaBuild\Repository\VendingStockRepository;

class VendingStockController extends AbstractController
{
    /**
     * @return void
     */
    public function addStockToVending(): void
    {

        if (isset($_POST['location'],$_POST['vending_id'],$_POST['batch_id'],$_POST['quantity'])) {
            $sCleanVendingId = intval(strip_tags($_POST['vending_id']));
            $sCleanBatchId = intval(strip_tags($_POST['batch_id']));
            $sCleanQuantity = intval(strip_tags($_POST['quantity']));
            $sCleanLocation = strip_tags($_POST['location']);

            $oVendingLocation = new VendingLocation($sCleanLocation,$sCleanVendingId);

            VendingLocationRepository::save($oVendingLocation);

            $oVendingStock = new VendingStock($sCleanQuantity,$sCleanBatchId,$oVendingLocation->getId());

            VendingStockRepository::save($oVendingStock);
        }
    }
}