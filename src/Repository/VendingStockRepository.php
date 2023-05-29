<?php

namespace DaBuild\Repository;

use DaBuild\Entity\VendingStock;
use DaBuild\Manager\DbManager;
use DateTime;

class VendingStockRepository extends AbstractRepository
{

    const TABLE = '`vending_stock`';

    /**
     * @param int|string $iId
     * @return bool
     */
    public static function isExist(int|string $iId): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT COUNT(*) AS nb FROM ' . static::TABLE . '
         WHERE `id` = :id';

        $oPdoVendingStock = $oPdo->prepare($sQuery);
        $oPdoVendingStock->bindValue(':id', $iId);
        $oPdoVendingStock->execute();

        $oDbInfo = $oPdoVendingStock->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param object $oVendingStock
     * @return void
     */
    public static function save(object $oVendingStock): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (
                                                `quantity`,
                                                `batch_id`,
                                                `updated_at`,
                                                `vending_location_id`)
        VALUES (
        :quantity,
        :batch_id,
        :updated_at,
        :vending_location_id)';

        $oPdoVendingStock = $oPdo->prepare($sQuery);

        $oPdoVendingStock->bindValue(':quantity', $oVendingStock->getQuantity());
        $oPdoVendingStock->bindValue(':batch_id', $oVendingStock->getBatchesId());
        $oPdoVendingStock->bindValue(':updated_at', $oVendingStock->getUpdatedAt()->format('Y-m-d'));
        $oPdoVendingStock->bindValue(':vending_location_id', $oVendingStock->getVendingLocationId());

        $oPdoVendingStock->execute();

        $oVendingStock->setId($oPdo->lastInsertId());
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
            (`brand`LIKE :magicSearch )
            OR (`model`LIKE :magicSearch )
            OR (`name`LIKE :magicSearch ))';
            $aParams[':magicSearch'] = '%' . $aCriterias['magic-search'] . '%';
        }

        if (!empty($aCriterias['quantity'])) {
            $aWhere[]  = '`quantity` = :quantity' ;
            $aParams[':quantity']  = $aCriterias['quantity'];
        }
        if (!empty($aCriterias['batch_id'])) {
            $aWhere[]  = '`batch_id` = :batch_id' ;
            $aParams[':batch_id']  = $aCriterias['batch_id'];
        }
        if (!empty($aCriterias['vending_location_id'])) {
            $aWhere[]  = '`vending_location_id` = :vending_location_id' ;
            $aParams[':vending_location_id']  = $aCriterias['vending_location_id'];
        }

        if (!empty($aCriterias['updated_at'])) {
            $aWhere[]  = '`updated_at` = :updated_at' ;
            $aParams[':updated_at']  = $aCriterias['updated_at'];
        }

        if ((!empty($aCriterias['from']))) {
            $aWhere[] = '(`updated_at` >= :from)';
            $aParams[':from'] = $aCriterias['from'];
        }
        if ((!empty($aCriterias['to']))) {
            $aWhere[] = '(`updated_at` <= :to)';
            $aParams[':to'] = $aCriterias['to'] . ' 23:59:59';
        }

        $sWhere = '';

        if (!empty($aWhere)) {
            $sWhere = ' WHERE ' . implode(' AND ', $aWhere);
        }

        return [
            'where' => $sWhere,
            'params' => $aParams,
            'id'    => $aCriterias['id'] ?? ''
        ];

    }

    /**
     * @param array $aDBVendingStock
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBVendingStock): object
    {
        $oVendingStock = new VendingStock(
            $aDBVendingStock['quantity'],
            $aDBVendingStock['batch_id'],
            $aDBVendingStock['vending_location_id']);

        $oVendingStock->setId($aDBVendingStock['id']);
        $oVendingStock->setUpdatedAt(new \DateTime($aDBVendingStock['updated_at']));

        return $oVendingStock;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function findAll(): array
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT * FROM ' . static::TABLE . '
            ORDER BY ' . static::ORDERED_BY . ' DESC ' ;

        $oPdoVendingStock = $oPdo->prepare($sQuery);

        return static::extracted($oPdoVendingStock);

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

        $oPdoVendingStock = $oPdo->prepare($sQuery);
        $oPdoVendingStock->bindValue(':id', $iId, \PDO::PARAM_INT);
        $oPdoVendingStock->execute();

        $oDBVendingStock = $oPdoVendingStock->fetch();

        return $oDBVendingStock ? static::hydrate($oDBVendingStock) : NULL;
    }

//    function getVendingStock(array $aVendingStocks, VendingLocation $oVendingLocation, Batch $oBatch): ?array
//    {
//
//        foreach ($aVendingStocks as $aVendingStock) {
//            foreach ($aVendingStock as $oVendingStock) {
//                if ($oVendingStock->getVendingLocationId() === $oVendingLocation->getId()) {
//                    $iBatchId = $oVendingStock->getBatchesId();
//                    if ($oBatch->getId() === $iBatchId) {
//                        return (new BatchRepository())->buildBatchInfos($oBatch, $oVendingStock);
//                    }
//                }
//            }
//        }
//        return NULL;
//    }

//    public static function findWhere(array $aVendingLocation): array
//    {
//
//        $oPdo = DbManager::getInstance();
//        $aList = [];
//
//            foreach ($aVendingLocation as $key => $oVendingLocation) {
//                $oDbVendingStock = $oPdo->query(
//                    'SELECT * FROM ' . static::TABLE .
//                    ' WHERE `vending_location_id` = ' . $oVendingLocation->getId()
//                );
//
//                $aList[$key] = static::extracted($oDbVendingStock);
//            }
//
//        return $aList;
//    }

}