<?php

namespace DaBuild\Repository;

use DaBuild\Entity\VendingPerCustomer;
use DaBuild\Entity\Vending;
use DaBuild\Manager\DbManager;

class VendingPerCustomerRepository extends AbstractRepository
{

    const TABLE = '`vending_per_customer`';
    const ORDERED_BY = '`status`';

    /**
     * @param int|string $iId
     * @return bool
     */
    public static function isExist(int|string $iId): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT COUNT(*) AS nb FROM ' . static::TABLE . '
         WHERE `id` = :id';

        $oPdoVendingPerCustomer = $oPdo->prepare($sQuery);
        $oPdoVendingPerCustomer->bindValue(':id', $iId);
        $oPdoVendingPerCustomer->execute();

        $oDbInfo = $oPdoVendingPerCustomer->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param object $oVendingPerCustomer
     * @return void
     */
    public static function save(object $oVendingPerCustomer): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (
                                                `status`,
                                                `vending_id`,
                                                `customer_id`)
        VALUES (
        :status,
        :vending_id,
        :customer_id)';

        $oPdoVendingPerCustomer = $oPdo->prepare($sQuery);

        $oPdoVendingPerCustomer->bindValue(':status', $oVendingPerCustomer->getStatus());
        $oPdoVendingPerCustomer->bindValue(':vending_id', $oVendingPerCustomer->getVendingId());
        $oPdoVendingPerCustomer->bindValue(':customer_id', $oVendingPerCustomer->getCustomerId());

        $oPdoVendingPerCustomer->execute();

        $oVendingPerCustomer->setId($oPdo->lastInsertId());
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
            (``LIKE :magicSearch )
            OR (``LIKE :magicSearch ))';
            $aParams[':magicSearch'] = '%' . $aCriterias['magic-search'] . '%';
        }

        if (!empty($aCriterias['status'])) {
            $aWhere[] = '`status` = :status';
            $aParams[':status'] = $aCriterias['status'];
        }
        if (!empty($aCriterias['customer_id'])) {
            $aWhere[] = '`customer_id` = :customer_id';
            $aParams[':customer_id'] = $aCriterias['customer_id'];
        }
        if (!empty($aCriterias['install_date'])) {
            $aWhere[] = '`install_date` = :install_date';
            $aParams[':install_date'] = $aCriterias['install_date'];
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
            'params' => $aParams,
            'id' => $aCriterias['id'] ?? ''
        ];

    }

    /**
     * @param array $aDBVendingPerCustomer
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBVendingPerCustomer): object
    {
        $oVendingPerCustomer = new VendingPerCustomer(
            $aDBVendingPerCustomer['vending_id'],
            $aDBVendingPerCustomer['customer_id'],
            $aDBVendingPerCustomer['status']);

        $oVendingPerCustomer->setId($aDBVendingPerCustomer['id']);
        $oVendingPerCustomer->setInstallData(new \DateTime($aDBVendingPerCustomer['install_date']));

        return $oVendingPerCustomer;
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

        $oPdoVendingPerCustomer = $oPdo->prepare($sQuery);

        return static::extracted($oPdoVendingPerCustomer);

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

        $oPdoVendingPerCustomer = $oPdo->prepare($sQuery);
        $oPdoVendingPerCustomer->bindValue(':id', $iId, \PDO::PARAM_INT);
        $oPdoVendingPerCustomer->execute();

        $oDBVendingPerCustomer = $oPdoVendingPerCustomer->fetch();

        return $oDBVendingPerCustomer ? static::hydrate($oDBVendingPerCustomer) : NULL;
    }


    public static function findByCustomer(int $iCustomerId): array
    {
        $oPdo = DbManager::getInstance();

        $oDbVending = $oPdo->query('SELECT * FROM ' . static::TABLE . ' WHERE `customer_id` = ' . $iCustomerId);

        return static::extracted($oDbVending);
    }
}