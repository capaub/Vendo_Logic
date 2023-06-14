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
    abstract public static function save(Object $O): void;

    /**
     * @param array $aCriterias
     * @return array
     */
    abstract protected static function buildCriterias(array $aCriterias): array;

    /**
     * @param array $aDB
     * @return Object
     */
    abstract public static function hydrate(array $aDB): Object;

    /**
     * @return array
     */
    abstract public static function findAll(): array;

    /**
     * @param int $iId
     * @return Object|null
     */
    abstract public static function find(int $iId): ?Object;


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

        if ($iOffset < 0){
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

        $sQuery = ' SELECT COUNT(*) AS nbElts FROM '.static::TABLE;
        $sQuery .= $aResultCriterias['where'];

        $oPdoStmt = $oPdo->prepare($sQuery);
        $oPdoStmt->execute($aResultCriterias['params']) ;

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

    /**
     * @return void
     */
//    protected static function BuildForm()
//    {
//        $oPdo = DbManager::getInstance();
//        $sTableName = static::TABLE;
//        $sDBName = DB_NAME;
//
//// requête pour récupérer le nombre de colonnes
//        $sQuery = "SELECT count(COLUMN_NAME) as count FROM information_schema.COLUMNS
//        WHERE table_name = '" . $sTableName . "'
//        AND table_schema = '" . $sDBName . "'
//        AND COLUMN_NAME NOT LIKE '%\_at'
//        AND COLUMN_NAME NOT LIKE '%\_date'
//        AND COLUMN_NAME NOT LIKE '%id'";
//
//        $oPdoStmt = $oPdo->query($sQuery);
//        $oDBCount = $oPdoStmt->fetch();
//        $iNbColumn = $oDBCount["count"];
//
//// requête pour récupérer les noms des colonnes
//        $sQuery = "SELECT COLUMN_NAME as column_name FROM information_schema.COLUMNS
//        WHERE table_name = '" . $sTableName . "'
//        AND table_schema = '" . $sDBName . "'
//        AND COLUMN_NAME NOT LIKE '%\_at'
//        AND COLUMN_NAME NOT LIKE '%\_date'
//        AND COLUMN_NAME NOT LIKE '%id'";
//
//        $oPdoStmt = $oPdo->query($sQuery);
//        $aColumnName = array();
//        while ($oDBColumnName = $oPdoStmt->fetch()) {
//            $aColumnName[] = $oDBColumnName["column_name"];
//        }
//
//// créer un formulaire automatiquement
//
//
//        echo '<main class="Container_main Main">
//    <h1 class="Main_title">Création automatisé d\'un formulaire</h1>';
//
//        var_dump($iNbColumn);
//        var_dump($aColumnName);
//        echo '<form method="POST"
//          class="form_container">
//        <fieldset class="fieldset">
//            <legend>legend</legend>';
//        for ($i = 0; $i < $iNbColumn; $i++) {
//
//            // Modification de la string de la bdd
//            $labelToLower = strtolower($aColumnName[$i]);
//            $labelForUser = ucfirst(str_replace('_', ' ', $labelToLower));
//
//            echo '
//                    <div class="elements">
//                        <input
//                        required
//                        type="text"
//                        id="firstname"
//                        name="field_' . $labelToLower . '" id="' . $labelToLower . '">
//                        <label for="' . $labelToLower . '">' . $labelForUser . '</label>
//                    </div>';
//        }
//        echo '</fieldset>';
//        echo '
//        <div class="elements submit">
//            <input type="submit" name="form_' . $sTableName . '" value="Envoyer">
//        </div>';
//        echo '</form>';
//    }
}