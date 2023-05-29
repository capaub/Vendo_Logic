<?php

namespace DaBuild\Repository;

use DaBuild\Entity\Company;
use DaBuild\Manager\DbManager;

class CompanyRepository extends AbstractRepository
{

    const TABLE = '`company`';


    /**
     * @param int|string $value
     * @return bool
     */
    public static function isExist(int|string $value): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT COUNT(*) AS nb FROM ' . static::TABLE . ' WHERE `siret` = :siret';
        $aParams = [':siret' => $value];

        if (intval($value)){

            $sQuery = 'SELECT COUNT(*) AS nb FROM ' . static::TABLE . ' WHERE `id` = :id';
            $aParams = [':id' => $value];
        }

        $oPdoCompany = $oPdo->prepare($sQuery);
        $oPdoCompany->execute($aParams);

        $oDbInfo = $oPdoCompany->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param object $oCompany
     * @return void
     */
    public static function save(object $oCompany): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (
                                                `siret`,
                                                `name`)
        VALUES (
        :siret,
        :name)';

        $oPdoCompany = $oPdo->prepare($sQuery);

        $oPdoCompany->bindValue(':siret', $oCompany->getSiret());
        $oPdoCompany->bindValue(':name', $oCompany->getName());

        $oPdoCompany->execute();

        $oCompany->setId($oPdo->lastInsertId());
    }

    /**
     * @param array $aCriterias
     * @return array
     */
    protected static function buildCriterias(array $aCriterias): array
    {
        $aWhere = $aParams = [];

        if (!empty($aCriterias['magic-search'])) {
            $aWhere[] = '((`siret`LIKE :magicSearch ) OR (`name` LIKE :magicSearch ))';
            $aParams[':magicSearch'] = '%' . $aCriterias['magic-search'] . '%';
        }

        if (!empty($aCriterias['siret'])) {
            $aWhere[] = '(`siret` = :siret)';
            $aParams[':siret'] = $aCriterias['siret'];
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
     * @param array $aDBCompany
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBCompany): object
    {
        $oCompany = new Company(
            $aDBCompany['siret'],
            $aDBCompany['name']);

        $oCompany->setId($aDBCompany['id']);
        $oCompany->setCreatedAt(new \DateTime($aDBCompany['created_at']));

        return $oCompany;
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

        $oPdoCompany = $oPdo->prepare($sQuery);
        $oPdoCompany->execute();

        return static::extracted($oPdoCompany);

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

}