<?php

namespace DaBuild\Repository;

use DaBuild\Entity\Goods;
use DaBuild\Manager\DbManager;

class GoodsRepository extends AbstractRepository
{
    const TABLE = '`goods`';

    /**
     * @param int|string $sBarcode
     * @return bool
     */
    public static function isExist(int|string $sBarcode): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT COUNT(*) AS nb FROM ' . static::TABLE .
            ' WHERE `barcode` = :barcode AND `company_id` = :company_id';

        $oPdoGoods = $oPdo->prepare($sQuery);
        $oPdoGoods->bindValue(':barcode', $sBarcode);
        $oPdoGoods->bindValue(':company_id', $_SESSION['user']->getCompanyId());
        $oPdoGoods->execute();

        $oDbInfo = $oPdoGoods->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param object $oGoods
     * @return void
     */
    public static function save(object $oGoods): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (
                                                `barcode`,
                                                `brand`,
                                                `img`,
                                                `nutri_score`,
                                                `company_id`)
        VALUES (
        :barcode,
        :brand,
        :img,
        :nutri_score,
        :company_id)';

        $oPdoGoods = $oPdo->prepare($sQuery);

        $oPdoGoods->bindValue(':barcode', $oGoods->getBarcode());
        $oPdoGoods->bindValue(':brand', $oGoods->getBrand());
        $oPdoGoods->bindValue(':img', $oGoods->getImg());
        $oPdoGoods->bindValue(':nutri_score', $oGoods->getNutriScore());
        $oPdoGoods->bindValue(':company_id', $oGoods->getCompanyId());

        $oPdoGoods->execute();

        $oGoods->setId($oPdo->lastInsertId());
    }

    /**
     * @param array $aCriterias
     * @return array
     */
    public static function buildCriterias(array $aCriterias): array
    {
        $aWhere = $aParams = [];

        if (!empty($aCriterias['magic-search'])) {
            $aWhere[] = '(
            (`brand`LIKE :magicSearch ))';
            $aParams[':magicSearch'] = '%' . $aCriterias['magic-search'] . '%';
        }

        if (!empty($aCriterias['barcode'])) {
            $aWhere[] = '(`barcode` = :barcode)';
            $aParams[':barcode'] = $aCriterias['barcode'];
        }

        if ((!empty($aCriterias['from']))) {
            $aWhere[] = '(`created_at` >= :from)';
            $aParams[':from'] = $aCriterias['from'];
        }
        if ((!empty($aCriterias['to']))) {
            $aWhere[] = '(`created_at` <= :to)';
            $aParams[':to'] = $aCriterias['to'] . ' 23:59:59';
        }

        $sWhere = '';

        if (!empty($aWhere)) {
            $sWhere = ' WHERE ' . implode(' AND ', $aWhere);
        }

        return [
            'where' => $sWhere,
            'params' => $aParams
        ];
    }

    /**
     * @param array $aDBGoods
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBGoods): object
    {
        $oGoods = new Goods(
            $aDBGoods['barcode'],
            $aDBGoods['brand'],
            $aDBGoods['img'],
            $aDBGoods['nutri_score'],
            $aDBGoods['company_id']);

        $oGoods->setId($aDBGoods['id']);
        $oGoods->setCreatedAt(new \DateTime($aDBGoods['created_at']));

        return $oGoods;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function findAll(): array
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT * FROM ' . static::TABLE . '
            WHERE `company_id` = :company_id
            ORDER BY ' . static::ORDERED_BY . ' DESC ';

        $oPdoCustomer = $oPdo->prepare($sQuery);
        $oPdoCustomer->execute([':company_id' => $_SESSION['user']->getCompanyId()]);

        return static::extracted($oPdoCustomer);
    }

    /**
     * @param int $iId
     * @return Object|null
     * @throws \Exception
     */
    public static function find(int $iId): ?object
    {

        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT * FROM ' . static::TABLE . ' WHERE `id` =  :id';

        $oPdoBatch = $oPdo->prepare($sQuery);
        $oPdoBatch->bindValue(':id', $iId, \PDO::PARAM_INT);
        $oPdoBatch->execute();

        $oDBBatch = $oPdoBatch->fetch();

        return $oDBBatch ? static::hydrate($oDBBatch) : NULL;
    }

    /**
     * @param string $barcode
     * @return Goods
     * @throws \Exception
     */
    public static function getGoodsByBarcode(string $barcode): Goods
    {
        $aCriterias = ['barcode' => $barcode];
        $aGoods = GoodsRepository::findBy($aCriterias);

        return $aGoods[0];
    }
}