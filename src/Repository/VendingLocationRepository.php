<?php

namespace DaBuild\Repository;

use DaBuild\Entity\VendingLocation;
use DaBuild\Manager\DbManager;

class VendingLocationRepository extends AbstractRepository
{

    const TABLE = '`vending_location`';

    /**
     * @param int|string $iId
     * @return bool
     */
    public static function isExist(int|string $iId): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT COUNT(*) AS nb FROM ' . static::TABLE . '
         WHERE `id` = :id';

        $oPdoVendingLocation = $oPdo->prepare($sQuery);
        $oPdoVendingLocation->bindValue(':id', $iId);
        $oPdoVendingLocation->execute();

        $oDbInfo = $oPdoVendingLocation->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param object $oVendingLocation
     * @return void
     */
    public static function save(object $oVendingLocation): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (
                                                `location`,
                                                `vending_id`)
        VALUES (
        :location,
        :vending_id)';

        $oPdoVendingLocation = $oPdo->prepare($sQuery);

        $oPdoVendingLocation->bindValue(':location', $oVendingLocation->getLocation());
        $oPdoVendingLocation->bindValue(':vending_id', $oVendingLocation->getVendingId());

        $oPdoVendingLocation->execute();

        $oVendingLocation->setId($oPdo->lastInsertId());
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

        if (!empty($aCriterias['vending_id'])) {
            $aWhere[] = '`vending_id` = :vending_id';
            $aParams[':vending_id'] = $aCriterias['vending_id'];
        }
        if (!empty($aCriterias['created_at'])) {
            $aWhere[] = '`created_at` = :created_at';
            $aParams[':created_at'] = $aCriterias['created_at'];
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
            'id' => $aCriterias['id']
        ];

    }

    /**
     * @param array $aDBVendingLocation
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBVendingLocation): object
    {
        $oVendingLocation = new VendingLocation(
            $aDBVendingLocation['location'],
            $aDBVendingLocation['vending_id']);

        $oVendingLocation->setId($aDBVendingLocation['id']);
        $oVendingLocation->setCreatedAt(new \DateTime($aDBVendingLocation['created_at']));

        return $oVendingLocation;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function findAll(): array
    {

        $iVendingId = $_POST['vending_id'] ?? $_GET['vending_id'];

        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT * FROM ' . static::TABLE . '
            WHERE `vending_id` = :vending_id
            ORDER BY ' . static::ORDERED_BY . ' DESC ';

        $oPdoVendingLocation = $oPdo->prepare($sQuery);
        $oPdoVendingLocation->execute([':vending_id' => $iVendingId]);

        return static::extracted($oPdoVendingLocation);
    }

    /**
     * @param $iVendingId
     * @return array
     * @throws \Exception
     */
    public static function findAllForOne($iVendingId): array
    {

        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT * FROM ' . static::TABLE . '
            WHERE `vending_id` = :vending_id
            ORDER BY ' . static::ORDERED_BY . ' DESC ';

        $oPdoVendingLocation = $oPdo->prepare($sQuery);
        $oPdoVendingLocation->execute([':vending_id' => $iVendingId]);

        return static::extracted($oPdoVendingLocation);
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

        $oPdoVendingLocation = $oPdo->prepare($sQuery);
        $oPdoVendingLocation->bindValue(':id', $iId, \PDO::PARAM_INT);
        $oPdoVendingLocation->execute();

        $oDBVendingLocation = $oPdoVendingLocation->fetch();

        return $oDBVendingLocation ? static::hydrate($oDBVendingLocation) : NULL;
    }

    /**
     * @param int $iVendingId
     * @return array
     * @throws \Exception
     */
    public static function findAllFromVending(int $iVendingId): array
    {
        $oPdo = DbManager::getInstance();

        $oPdoVendingLocation = $oPdo->prepare('SELECT * FROM ' . static::TABLE . ' WHERE `vending_id` = :vendingId');
        $oPdoVendingLocation->bindValue(':vendingId', $iVendingId, \PDO::PARAM_INT);
        $oPdoVendingLocation->execute();

        $aVendingLocation = [];
        $test = static::extracted($oPdoVendingLocation);
        foreach ($test as $key => $oVendingLocation) {
            $aVendingLocation[($oVendingLocation->getLocation())] = $oVendingLocation;
        }

        return $aVendingLocation;
    }

}