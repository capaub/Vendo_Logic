<?php

namespace DaBuild\Repository;

use DaBuild\Entity\Company;
use DaBuild\Entity\Customer;
use DaBuild\Manager\DbManager;

class CustomerRepository extends AbstractRepository
{
    const TABLE = '`customer`';

    /**
     * @param int|string $sSiret
     * @return bool
     */
    public static function isExist(int|string $sSiret): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT COUNT(*) AS nb FROM ' . static::TABLE . ' WHERE `siret` = :siret';

        $oPdoCompany = $oPdo->prepare($sQuery);
        $oPdoCompany->bindValue(':siret', $sSiret);
        $oPdoCompany->execute();

        $oDbInfo = $oPdoCompany->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param object $oCustomer
     * @return void
     */
    public static function save(object $oCustomer): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (
                                                `siret`,
                                                `company_name`,
                                                `email`,
                                                `phone`,
                                                `firstname`,
                                                `lastname`,
                                                `address_id`,
                                                `company_id`)
        VALUES (
        :siret,
        :company_name,
        :email,
        :phone,
        :firstname,
        :lastname,
        :address_id,
        :company_id)';

        $oPdoCustomer = $oPdo->prepare($sQuery);

        $oPdoCustomer->bindValue(':siret', $oCustomer->getSiret());
        $oPdoCustomer->bindValue(':company_name', $oCustomer->getCompanyName());
        $oPdoCustomer->bindValue(':email', $oCustomer->getEmail());
        $oPdoCustomer->bindValue(':phone', $oCustomer->getPhone());
        $oPdoCustomer->bindValue(':firstname', $oCustomer->getFirstname());
        $oPdoCustomer->bindValue(':lastname', $oCustomer->getLastname());
        $oPdoCustomer->bindValue(':address_id', $oCustomer->getAddressId());
        $oPdoCustomer->bindValue(':company_id', $oCustomer->getCompanyId());

        $oPdoCustomer->execute();

        $oCustomer->setId($oPdo->lastInsertId());
    }

    /**
     * @param array $aCriterias
     * @return array
     */
    protected static function buildCriterias(array $aCriterias): array
    {
        $aWhere = $aParams = [];

        if (!empty($aCriterias['magic-search'])) {
            $aWhere[] = '(
            (`email`LIKE :magicSearch ) 
            OR (`phone` LIKE :magicSearch )
            OR (`company_name` LIKE :magicSearch ))';
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
     * @param array $aDBCustomer
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBCustomer): object
    {
        $oCustomer = new Customer(
            $aDBCustomer['siret'],
            $aDBCustomer['company_name'],
            $aDBCustomer['email'],
            $aDBCustomer['phone'],
            $aDBCustomer['firstname'],
            $aDBCustomer['lastname'],
            $aDBCustomer['address_id'],
            $aDBCustomer['company_id']);

        $oCustomer->setId($aDBCustomer['id']);
        $oCustomer->setCreatedAt(new \DateTime($aDBCustomer['created_at']));

        return $oCustomer;
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
}