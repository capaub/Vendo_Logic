<?php

namespace DaBuild\Repository;

use DaBuild\Entity\Address;
use DaBuild\Manager\DbManager;

class AddressRepository extends AbstractRepository
{
    const TABLE = '`address`';


    /**
     * @param int|string $iId
     * @return bool
     */
    public static function isExist(int|string $iId): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT COUNT(*) AS nb FROM '.static::TABLE.' WHERE `id` = :id';
        $oPdoCompany = $oPdo->prepare($sQuery);
        $oPdoCompany->bindValue(':id', $iId);
        $oPdoCompany->execute();

        $oDbInfo = $oPdoCompany->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param object $oAddress
     * @return void
     */
    public static function save(object $oAddress): void
    {
        $oPdo = DbManager::getInstance();

        $iCompanyId = $_SESSION['company_id'] ?? $_SESSION['user']->getCompanyId();


        $sQuery = 'INSERT INTO '.static::TABLE.' (
                                                `address`,
                                                `postal_code`,
                                                `city`,
                                                `country`,
                                                `company_id`)
        VALUES (
        :address,
        :postal_code,
        :city,
        :country,
        :company_id)';

        $oPdoAddress = $oPdo->prepare($sQuery);


        $oPdoAddress->bindValue(':address', $oAddress->getStreetName());
        $oPdoAddress->bindValue(':postal_code', $oAddress->getPostalCode());
        $oPdoAddress->bindValue(':city', $oAddress->getCity());
        $oPdoAddress->bindValue(':country', $oAddress->getCountry());
        $oPdoAddress->bindValue(':company_id', $iCompanyId);

        $oPdoAddress->execute();

        $oAddress->setId($oPdo->lastInsertId());
    }

    /**
     * @param array $aCriterias
     * @return array
     */
    protected static function buildCriterias(array $aCriterias): array
    {
        $aWhere = $aParams = [];

        if (!empty($aCriterias['magic-search'])){
            $aWhere[] = '((`address`LIKE :magicSearch ) OR (`city` LIKE :magicSearch ))';
            $aParams[':magicSearch'] = '%'.$aCriterias['magic-search'].'%';
        }

        if (!empty($aCriterias['address'])){
            $aWhere[] = '(`address` = :address)';
            $aParams[':address'] = $aCriterias['address'];
        }

        if ((!empty($aCriterias['from']))){
            $aWhere[] = '(`created_at` >= :from)';
            $aParams[':from'] =  $aCriterias['from'];
        }
        if ((!empty($aCriterias['to']))){
            $aWhere[] = '(`created_at` <= :to)';
            $aParams[':to'] =  $aCriterias['to'] . ' 23:59:59';
        }

        $sWhere = '';

        if (!empty($aWhere)) {
            $sWhere = ' WHERE ' . implode(' AND ', $aWhere);
        }

        return [
            'where'     => $sWhere,
            'params'    => $aParams
        ];
    }

    /**
     * @param array $aDBAddress
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBAddress): object
    {
        $oAddress = new Address(
            $aDBAddress['country'],
            $aDBAddress['city'],
            $aDBAddress['postal_code'],
            $aDBAddress['address']);

        $oAddress->setId($aDBAddress['id']);
        $oAddress->setCreatedAt(new \DateTime($aDBAddress['created_at']));

        return $oAddress;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function findAll(): array //refactor
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT * FROM '.static::TABLE.'
            WHERE `company_id` = :company_id
            ORDER BY '.static::ORDERED_BY.' DESC ';

        $oPdoAddress = $oPdo->prepare($sQuery);

        $oPdoAddress->execute([':company_id' => $_SESSION['user']->getCompanyId()]);

        return static::extracted($oPdoAddress);

    }

    /**
     * @param int $iId
     * @return Object|null
     * @throws \Exception
     */
    public static function find(int $iId): ?object
    {

        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT * FROM '.static::TABLE.' WHERE `id` =  :id';

        $oPdoAddress = $oPdo->prepare($sQuery);
        $oPdoAddress->bindValue(':id', $iId, \PDO::PARAM_INT);
        $oPdoAddress->execute();

        $oDbAddress = $oPdoAddress->fetch();

        return $oDbAddress ? static::hydrate($oDbAddress) : NULL;
    }


}