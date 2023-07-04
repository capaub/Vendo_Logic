<?php

namespace DaBuild\Repository;


use DaBuild\Manager\DbManager;

abstract class AbstractRepository
{
    const TABLE = NULL;
    const ORDERED_BY = '`created_at`';
    const NB_ELTS_PER_PAGE = 25;


    /**
     * @param string|int $by
     * @return bool
     */
    abstract public static function isExist(string|int $by): bool;

    /**
     * @param Object $O
     * @return void
     */
    abstract public static function save(object $O): void;

    /**
     * @param array $aCriterias
     * @return array
     */
    abstract protected static function buildCriterias(array $aCriterias): array;

    /**
     * @param array $aDB
     * @return Object
     */
    abstract public static function hydrate(array $aDB): object;

    /**
     * @return array
     */
    abstract public static function findAll(): array;

    /**
     * @param int $iId
     * @return Object|null
     */
    abstract public static function find(int $iId): ?object;


    /**
     * @param array $aCriterias
     * @param int $iOffset
     * @param int $iNbElts
     * @return array
     * @throws \Exception
     */
    public static function findBy(array $aCriterias, int $iOffset = 0, int $iNbElts = self::NB_ELTS_PER_PAGE): array
    {
        $oPdo = DbManager::getInstance();

        $aResult = static::buildCriterias($aCriterias);

        if ($iOffset < 0) {
            $iOffset = 0;
        }

        $sQuery = ' SELECT * FROM ' . static::TABLE . $aResult['where'];

        $sQuery .= ' LIMIT ' . $iOffset . ',' . $iNbElts;

        $oPdoStmt = $oPdo->prepare($sQuery);
        $oPdoStmt->execute($aResult['params']);

        return static::extracted($oPdoStmt);
    }

    /**
     * @param array $aCriterias
     * @return int
     */
    public static function countBy(array $aCriterias = []): int
    {
        $oPdo = DbManager::getInstance();

        $aResultCriterias = static::buildCriterias($aCriterias);

        $sQuery = ' SELECT COUNT(*) AS nbElts FROM ' . static::TABLE;
        $sQuery .= $aResultCriterias['where'];

        $oPdoStmt = $oPdo->prepare($sQuery);
        $oPdoStmt->execute($aResultCriterias['params']);

        $oBdInfo = $oPdoStmt->fetch(\PDO::FETCH_ASSOC);

        return $oBdInfo['nbElts'];
    }


    /**
     * @param \PDOStatement $oPdoStmt
     * @return array
     * @throws \Exception
     */
    protected static function extracted(\PDOStatement $oPdoStmt): array
    {
        $aList = [];

        while ($oDbInfo = $oPdoStmt->fetch()) {
            $aList[] = static::hydrate($oDbInfo);
        }

        return $aList;
    }
}