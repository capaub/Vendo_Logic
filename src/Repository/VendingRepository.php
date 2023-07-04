<?php

namespace DaBuild\Repository;

use DaBuild\Entity\Vending;
use DaBuild\Manager\DbManager;
use DateTime;

class VendingRepository extends AbstractRepository
{

    const TABLE = '`vending`';

    /**
     * @param int|string $iId
     * @return bool
     */
    public static function isExist(int|string $iId): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT COUNT(*) AS nb FROM ' . static::TABLE . '
         WHERE `id` = :id';

        $oPdoVending = $oPdo->prepare($sQuery);
        $oPdoVending->bindValue(':id', $iId);
        $oPdoVending->execute();

        $oDbInfo = $oPdoVending->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param object $oVending
     * @return void
     */
    public static function save(object $oVending): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (
                                                `brand`,
                                                `model`,
                                                `name`,
                                                `max_tray`,
                                                `max_spiral`,
                                                `company_id`)
        VALUES (
        :brand,
        :model,
        :name,
        :max_tray,
        :max_spiral,
        :company_id)';

        $oPdoVending = $oPdo->prepare($sQuery);

        $oPdoVending->bindValue(':brand', $oVending->getBrand());
        $oPdoVending->bindValue(':model', $oVending->getModel());
        $oPdoVending->bindValue(':name', $oVending->getName());
        $oPdoVending->bindValue(':max_tray', $oVending->getNbMaxTray());
        $oPdoVending->bindValue(':max_spiral', $oVending->getNbMaxSpiral());
        $oPdoVending->bindValue(':company_id', $oVending->getCompanyId());

        $oPdoVending->execute();

        $oVending->setId($oPdo->lastInsertId());
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

        if (!empty($aCriterias['brand'])) {
            $aWhere[] = '`brand` = :brand';
            $aParams[':brand'] = $aCriterias['brand'];
        }
        if (!empty($aCriterias['model'])) {
            $aWhere[] = '`model` = :model';
            $aParams[':model'] = $aCriterias['model'];
        }
        if (!empty($aCriterias['name'])) {
            $aWhere[] = '`name` = :name';
            $aParams[':name'] = $aCriterias['name'];
        }
        if (!empty($aCriterias['max_tray'])) {
            $aWhere[] = '`max_tray` = :max_tray';
            $aParams[':max_tray'] = $aCriterias['max_tray'];
        }
        if (!empty($aCriterias['max_spiral'])) {
            $aWhere[] = '`max_spiral` = :max_spiral';
            $aParams[':max_spiral'] = $aCriterias['max_spiral'];
        }
        if (!empty($aCriterias['update_at'])) {
            $aWhere[] = '`update_at` = :update_at';
            $aParams[':update_at'] = $aCriterias['update_at'];
        }
        if (!empty($aCriterias['qr_code'])) {
            $aWhere[] = '`qr_code` = :qr_code';
            $aParams[':qr_code'] = $aCriterias['qr_code'];
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
            'id' => $aCriterias['id'] ?? ''
        ];

    }

    /**
     * @param array $aDBVending
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBVending): object
    {
        $oVending = new Vending(
            $aDBVending['brand'],
            $aDBVending['model'],
            $aDBVending['max_tray'],
            $aDBVending['max_spiral'],
            $aDBVending['company_id']);

        $oVending->setId($aDBVending['id']);
        $oVending->setCreatedAt(new DateTime($aDBVending['created_at']));

        if ($aDBVending['name'] !== NULL) {
            $oVending->setName($aDBVending['name']);
        }
        if ($aDBVending['qr_code'] !== NULL) {
            $oVending->setQrCode($aDBVending['qr_code']);
        }

        return $oVending;
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

        $oPdoVending = $oPdo->prepare($sQuery);
        $oPdoVending->execute([':company_id' => $_SESSION['user']->getCompanyId()]);

        return static::extracted($oPdoVending);

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

        $oPdoVending = $oPdo->prepare($sQuery);
        $oPdoVending->execute([':id' => $iId]);

        $oDBVending = $oPdoVending->fetch();

        return $oDBVending ? static::hydrate($oDBVending) : NULL;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function getAvailableVending(): array
    {
        $oPdo = DbManager::getInstance();
        $sQuery = 'SELECT * 
               FROM ' . static::TABLE . '
               WHERE `company_id` = :company_id
               AND (
                   `id` NOT IN (SELECT `vending_id` FROM `vending_per_customer`)
                   OR (`id` IN (SELECT `vending_id` FROM `vending_per_customer` WHERE `status` = 0))
               )';

        $oPdoVending = $oPdo->prepare($sQuery);

        // Vérifier si la table `vending` est vide
        $sCountQuery = 'SELECT COUNT(*) AS count FROM ' . static::TABLE;
        $oCountStatement = $oPdo->query($sCountQuery);
        $rowCount = $oCountStatement->fetchColumn();

        if ($rowCount > 0) {
            // La table n'est pas vide, exécute la requête avec les paramètres
            $oPdoVending->execute([':company_id' => $_SESSION['user']->getCompanyId()]);
            return VendingRepository::extracted($oPdoVending);
        } else {
            // La table est vide, retourne un tableau vide
            return [];
        }
    }

    /**
     * @param array $aUpdateData
     * @return void
     */
    public static function update(array $aUpdateData): void
    {
        $oPdo = DbManager::getInstance();

        $aUpdateData['where'] .= ' AND (`updated_at` = :updated_at)';
        $aUpdateData['params'][':updated_at'] = (new \DateTime('now'))->format('Y-m-d H:i:s');


        $sModifiedWhereToSetQuery = str_replace(
            ['WHERE', 'AND', '(', ')'],
            ['SET', ', ', ' ', ' '],
            $aUpdateData['where']);

        $sQuery =
            ' UPDATE ' . static::TABLE
            . $sModifiedWhereToSetQuery .
            ' WHERE `id` = :id';

        $stmt = $oPdo->prepare($sQuery);

        $stmt->bindValue(':id', $aUpdateData['id'], \PDO::PARAM_INT);
        foreach ($aUpdateData['params'] as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();
    }

}