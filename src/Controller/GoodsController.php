<?php

namespace DaBuild\Controller;

use DaBuild\Entity\Goods;
use DaBuild\Repository\GoodsRepository;

class GoodsController extends AbstractController
{

    public function createGoods($oProductDetails): void
    {
        $url = $oProductDetails['image_url']; // URL de l'image à récupérer
        $contents = file_get_contents($url); // Récupération du contenu de l'image
        $sFilenameNew = PREFIX_BATCH_IMG . $oProductDetails['_id'] . '.jpg'; // Génération d'un nom de fichier (code-barre)
        $FilepathNew = DIR_PRODUCTS_IMG . DIRECTORY_SEPARATOR . $sFilenameNew; // Chemin complet du fichier à créer
        file_put_contents($FilepathNew, $contents); // Écriture du contenu de l'image dans le fichier local

        $oGoods = new Goods(
        $oProductDetails['_id'],
        $oProductDetails['brands'],
        $FilepathNew,
        strtoupper($oProductDetails['nutriscore_grade']),
        $_SESSION['user']->getCompanyId());

        GoodsRepository::save($oGoods);
    }

}