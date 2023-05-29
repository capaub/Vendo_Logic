<?php

namespace DaBuild\Repository;

use DaBuild\Entity\User;
use DaBuild\Manager\DbManager;

class UserRepository extends AbstractRepository
{
    const TABLE = '`user`';


    /**
     * @param int|string $sEmail
     * @return bool
     */
    public static function isExist(int|string $sEmail): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT COUNT(*) AS nb FROM ' . static::TABLE . '
         WHERE `email` = :email';

        $oPdoGoods = $oPdo->prepare($sQuery);
        $oPdoGoods->bindValue(':email', $sEmail);
        $oPdoGoods->execute();

        $oDbInfo = $oPdoGoods->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param object $oUser
     * @return void
     */
    public static function save(object $oUser): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (
                                                `firstname`,
                                                `lastname`,
                                                `email`,
                                                `password`,
                                                `role`,
                                                `address_id`,
                                                `company_id`)
        VALUES (
        :firstname,
        :lastname,
        :email,
        :password,
        :role,
        :address_id,
        :company_id)';

        $oPdoUser = $oPdo->prepare($sQuery);

        $oPdoUser->bindValue(':firstname', $oUser->getFirstname());
        $oPdoUser->bindValue(':lastname', $oUser->getLastname());
        $oPdoUser->bindValue(':email', $oUser->getEmail());
        $oPdoUser->bindValue(':password', $oUser->getPassword());
        $oPdoUser->bindValue(':role', $oUser->getRole());
        $oPdoUser->bindValue(':address_id', $oUser->getAddressId());
        $oPdoUser->bindValue(':company_id', $oUser->getCompanyId());

        $oPdoUser->execute();

        $oUser->setId($oPdo->lastInsertId());
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
            (`firstname`LIKE :magicSearch )
            OR (`lastname`LIKE :magicSearch ))';
            $aParams[':magicSearch'] = '%' . $aCriterias['magic-search'] . '%';
        }

        if (!empty($aCriterias['firstname'])) {
            $aWhere[] = '`firstname` = :firstname';
            $aParams[':firstname'] = $aCriterias['firstname'];
        }
        if (!empty($aCriterias['lastname'])) {
            $aWhere[] = '`lastname` = :lastname';
            $aParams[':lastname'] = $aCriterias['lastname'];
        }
        if (!empty($aCriterias['email'])) {
            $aWhere[] = '`email` = :email';
            $aParams[':email'] = $aCriterias['email'];
        }
        if (!empty($aCriterias['password'])) {
            $aWhere[] = '`password` = :password';
            $aParams[':password'] = $aCriterias['password'];
        }
        if (!empty($aCriterias['role'])) {
            $aWhere[] = '`role` = :role';
            $aParams[':role'] = $aCriterias['role'];
        }
        if (!empty($aCriterias['connected_at'])) {
            $aWhere[] = '`connected_at` = :connected_at';
            $aParams[':connected_at'] = $aCriterias['connected_at'];
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

        if ($aWhere > 1) {
            $sWhere = ' WHERE ' . implode(' AND ', $aWhere);
        }


        return [
            'where' => $sWhere,
            'params' => $aParams,
            'id' => $aCriterias['id'] ?? ''
        ];

    }

    /**
     * @param array $aDBUser
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBUser): object
    {
        $oUser = new User(
            $aDBUser['firstname'],
            $aDBUser['lastname'],
            $aDBUser['email'],
            $aDBUser['company_id'],
            $aDBUser['address_id'],
            $aDBUser['password'],
            $aDBUser['role']);

        $oUser->setId($aDBUser['id']);
        $oUser->setCreatedAt(new \DateTime($aDBUser['created_at']));

        if (!empty($aDBUser['connected_at'])) {
            $oUser->setConnectedAt(new \DateTime($aDBUser['connected_at']));
        } else {
            $oUser->setConnectedAt(null);
        }

        return $oUser;
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
     * @param array $aUpdateData
     * @return void
     */
    public static function update(array $aUpdateData): void
    {

        $oPdo = DbManager::getInstance();

        if (empty($aUpdateData['params'][':connected_at'])) {
            $aUpdateData['where'] .= ' AND `updated_at` = :updated_at';
            $aUpdateData['params'][':updated_at'] = (new \DateTime('now'))->format('Y-m-d H:i:s');
        }

        $sModifiedWhereToSetQuery = str_replace(
            ['WHERE', 'AND', '(', ')'],
            [' ', ', ', ' ', ' '],
            $aUpdateData['where']);

        $sQuery =
            ' UPDATE ' . static::TABLE .
            ' SET ' . $sModifiedWhereToSetQuery .
            ' WHERE `id` = :id';

        $stmt = $oPdo->prepare($sQuery);


        $stmt->bindValue(':id', $aUpdateData['id'], \PDO::PARAM_INT);
        foreach ($aUpdateData['params'] as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();
    }

    /**
     * @param int $iUserId
     * @return void
     */
    public static function delete(int $iUserId): void
    {

        $oPdo = DbManager::getInstance();

        $sQuery = 'DELETE FROM ' . static::TABLE . ' WHERE `id` = :id';

        $stmt = $oPdo->prepare($sQuery);
        $stmt->bindValue(':id', $iUserId, \PDO::PARAM_INT);

        $stmt->execute();
    }

}