<?php

namespace DaBuild\Controller;

use DaBuild\Entity\Goods;
use DaBuild\Repository\GoodsRepository;

class GoodsController extends AbstractController
{

    public function createGoods($oProductDetails): void
    {
        $url = $oProductDetails['image_url'];
        $contents = file_get_contents($url);
        $sFilenameNew = PREFIX_BATCH_IMG . $oProductDetails['_id'] . '.jpg';
        $FilepathNew = DIR_PRODUCTS_IMG . DIRECTORY_SEPARATOR . $sFilenameNew;
        file_put_contents($FilepathNew, $contents);

        $oGoods = new Goods(
            $oProductDetails['_id'],
            $oProductDetails['brands'],
            $FilepathNew,
            strtoupper($oProductDetails['nutriscore_grade']),
            $_SESSION['user']->getCompanyId());

        GoodsRepository::save($oGoods);
    }

}