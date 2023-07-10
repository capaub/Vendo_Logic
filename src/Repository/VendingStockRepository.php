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
     * @throws \Exception
     */
    public static function save(object $oVendingStock): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'START TRANSACTION;
                   INSERT INTO ' . static::TABLE . ' (`quantity`, 
                                                      `batch_id`, 
                                                      `updated_at`, 
                                                      `vending_location_id`)
                   VALUES (:quantity, 
                           :batch_id, 
                           :updated_at, 
                           :vending_location_id);
                           
                   UPDATE ' . BatchRepository::TABLE . '
                   JOIN (SELECT * FROM ' . BatchRepository::TABLE . ' WHERE `id` = :batch_id) AS subquerry
                   SET ' . BatchRepository::TABLE . '.`quantity` = subquerry.`quantity` - :quantity
                   WHERE ' . BatchRepository::TABLE . '.`id` = :batch_id;
                   
                   COMMIT;';

        $oPdoVendingStock = $oPdo->prepare($sQuery);

        $oPdoVendingStock->execute([
            ':quantity' => $oVendingStock->getQuantity(),
            ':batch_id' => $oVendingStock->getBatchId(),
            ':updated_at' => $oVendingStock->getUpdatedAt()->format('Y-m-d'),
            ':vending_location_id' => $oVendingStock->getVendingLocationId()
        ]);

        if ($oPdoVendingStock->rowCount() === 0) {
            $_SESSION['flashes'][] = ['ERROR' => 'quantité du lot insuffisante'];
        }

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
            $aWhere[] = '`quantity` = :quantity';
            $aParams[':quantity'] = $aCriterias['quantity'];
        }
        if (!empty($aCriterias['batch_id'])) {
            $aWhere[] = '`batch_id` = :batch_id';
            $aParams[':batch_id'] = $aCriterias['batch_id'];
        }
        if (!empty($aCriterias['vending_location_id'])) {
            $aWhere[] = '`vending_location_id` = :vending_location_id';
            $aParams[':vending_location_id'] = $aCriterias['vending_location_id'];
        }

        if (!empty($aCriterias['updated_at'])) {
            $aWhere[] = '`updated_at` = :updated_at';
            $aParams[':updated_at'] = $aCriterias['updated_at'];
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
            'id' => $aCriterias['id'] ?? ''
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
        if ($aDBVendingStock['updated_at'] !== null) {
            $oVendingStock->setUpdatedAt(new \DateTime($aDBVendingStock['updated_at']));
        }

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
            ORDER BY ' . static::ORDERED_BY . ' DESC ';

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
}






//TODO modifier la requête pour voir si la quantité est disponible
//START TRANSACTION;
//
//    SET @newQuantity = (
//SELECT `quantity` - :quantity
//        FROM ' . BatchRepository::TABLE . '
//        WHERE `id` = :batch_id
//        FOR UPDATE
//        );
//
//    IF (@newQuantity >= 0) THEN
//        INSERT INTO ' . static::TABLE . ' (`quantity`, `batch_id`, `updated_at`, `vending_location_id`)
//        VALUES (:quantity, :batch_id, :updated_at, :vending_location_id);
//
//        UPDATE ' . BatchRepository::TABLE . '
//        SET `quantity` = @newQuantity
//        WHERE `id` = :batch_id;
//    END IF;
//
//    COMMIT;';