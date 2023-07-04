<?php

namespace DaBuild\Repository;

use DaBuild\Entity\Batch;
use DaBuild\Entity\VendingStock;
use DaBuild\Manager\DbManager;
use DaBuild\Services\ExternalQrCodeAPIService;

class BatchRepository extends AbstractRepository
{
    const TABLE = '`batch`';
    const ORDERED_BY = '`dlc`';


    /**
     * @param int|string $iId
     * @return bool
     */
    public static function isExist(int|string $iId): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery =
            'SELECT COUNT(*) AS nb FROM ' . static::TABLE
            . ' WHERE `dlc` = :dlc AND `goods_id` = :goods_id  ';

        $oPdoBatch = $oPdo->prepare($sQuery);
        $oPdoBatch->bindValue(':id', $iId);
        $oPdoBatch->execute();

        $oDbInfo = $oPdoBatch->fetch(\PDO::FETCH_ASSOC);

        return ($oDbInfo['nb'] > 0);
    }

    /**
     * @param string $sDlc
     * @param int $sGoodsId
     * @return int|null
     */
    public static function isCombinationExist(string $sDlc, int $sGoodsId): ?int
    {
        $oPdo = DbManager::getInstance();

        $sQuery =
            'SELECT `id` FROM ' . static::TABLE
            . ' WHERE `dlc` = :dlc AND `dlc` = :dlc  '
            . ' AND `goods_id` = :goods_id AND `goods_id` = :goods_id  ';

        $oPdoBatch = $oPdo->prepare($sQuery);
        $oPdoBatch->bindValue(':dlc', $sDlc);
        $oPdoBatch->bindValue(':goods_id', $sGoodsId);
        $oPdoBatch->execute();

        $oDbInfo = $oPdoBatch->fetch(\PDO::FETCH_ASSOC);

        if ($oDbInfo && isset($oDbInfo['id'])) {
            return (int)$oDbInfo['id'];
        }

        return null;
    }

    /**
     * @param object $oBatch
     * @return void
     */
    public static function save(object $oBatch): void
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (
                                                `dlc`,
                                                `quantity`,
                                                `qr_code`,
                                                `goods_id`)
        VALUES (
        :dlc,
        :quantity,
        :qr_code,
        :goods_id)';

        $oPdoBatch = $oPdo->prepare($sQuery);

        $oPdoBatch->bindValue(':dlc', $oBatch->getDlc()->format('Y-m-d H:i:s'));
        $oPdoBatch->bindValue(':quantity', $oBatch->getQuantity());
        $oPdoBatch->bindValue(':qr_code', $oBatch->getQrCode());
        $oPdoBatch->bindValue(':goods_id', $oBatch->getGoodsId());

        $oPdoBatch->execute();

        $oBatch->setId($oPdo->lastInsertId());
    }

    /**
     * @param array $aCriterias
     * @return array
     */
    public static function buildCriterias(array $aCriterias): array
    {
        $aWhere = $aParams = [];

        if (!empty($aCriterias['magic-search'])) {
            $aWhere[] = '((`qr_code`LIKE :magicSearch ) OR (`quantity` LIKE :magicSearch ))';
            $aParams[':magicSearch'] = '%' . $aCriterias['magic-search'] . '%';
        }

        if (!empty($aCriterias['goods_id'])) {
            $aWhere[] = '(`goods_id` = :goods_id)';
            $aParams[':goods_id'] = $aCriterias['goods_id'];
        }
        if (!empty($aCriterias['quantity'])) {
            $aWhere[] = '(`quantity` = :quantity)';
            $aParams[':quantity'] = $aCriterias['quantity'];
        }
        if ((!empty($aCriterias['dlc']))) {
            $aWhere[] = '(`dlc` = :dlc)';
            $aParams[':dlc'] = $aCriterias['dlc'];
        }
        if (!empty($aCriterias['qr_code'])) {
            $aWhere[] = '(`qr_code` = :qr_code)';
            $aParams[':qr_code'] = $aCriterias['qr_code'];
        }
        if (!empty($aCriterias['sold_out_at'])) {
            $aWhere[] = '(`sold_out_at` = :sold_out_at)';
            $aParams[':sold_out_at'] = $aCriterias['sold_out_at'];
        }

        if ((!empty($aCriterias['from']))) {
            $aWhere[] = '(`dlc` >= :from)';
            $aParams[':from'] = $aCriterias['from'];
        }
        if ((!empty($aCriterias['to']))) {
            $aWhere[] = '(`dlc` <= :to)';
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
     * @param array $aDBBatch
     * @return Object
     * @throws \Exception
     */
    public static function hydrate(array $aDBBatch): object
    {
        $oBatch = new Batch(
            date_create($aDBBatch['dlc']),
            $aDBBatch['quantity'],
            $aDBBatch['qr_code'],
            $aDBBatch['goods_id']);

        $oBatch->setId($aDBBatch['id']);
        $oBatch->setCreatedAt(new \DateTime($aDBBatch['created_at']));
        $oBatch->setUpdatedAt(new \DateTime($aDBBatch['updated_at']));

        return $oBatch;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function findAll(): array
    {
        $oPdo = DbManager::getInstance();

        $sQuery = '
            SELECT * FROM ' . static::TABLE . '
            WHERE `goods_id` IN (SELECT `id` FROM ' . GoodsRepository::TABLE . '
                WHERE `company_id` = :company_id)
            ORDER BY ' . static::ORDERED_BY;

        $oPdoBatch = $oPdo->prepare($sQuery);

        $oPdoBatch->execute([':company_id' => $_SESSION['user']->getCompanyId()]);

        return static::extracted($oPdoBatch);

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
        $oPdoBatch->execute([':id' => $iId]);

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
        foreach ($aUpdateData['params'] as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        $stmt->bindValue(':id', $aUpdateData['id'], \PDO::PARAM_INT);

        $stmt->execute();

    }

    /**
     * @param Batch $oBatch
     * @param string $sQrCode
     * @return void
     */
    public static function updateBatchQrCode(Batch $oBatch, string $sQrCode): void
    {
        $aBatchCriterias = [
            'id' => $oBatch->getId(),
            'qr_code' => $sQrCode
        ];

        $aCriterias = static::buildCriterias($aBatchCriterias);

        static::update($aCriterias);
    }

    /**
     * @param string $dlc
     * @param int $quantity
     * @param string $qrCode
     * @param int $goodsId
     * @return Batch
     */
    public static function createNewBatch(string $dlc, int $quantity, string $qrCode, int $goodsId): Batch
    {
        $oBatch = new Batch(date_create($dlc), $quantity, $qrCode, $goodsId);
        static::save($oBatch);

        return $oBatch;
    }

    /**
     * @param int $iCompanyId
     * @param int $iGoodsId
     * @param string $sDlc
     * @param string $sQuantity
     * @return string
     */
    public static function generateTempQrCodeForBatch(int $iCompanyId, int $iGoodsId, string $sDlc, string $sQuantity): string
    {

        $iUniqId = uniqid();

        $aData =
            [
                'company_id' => $iCompanyId,
                'goods_id' => $iGoodsId,
                'uniqid' => $iUniqId,
                'dlc' => $sDlc,
                'quantity' => $sQuantity,
                'url' => $iCompanyId . ' ' . $iGoodsId . ' ' . $sDlc . ' ' . $sQuantity
            ];

        return ExternalQrCodeAPIService::generateQrCode($aData);
    }

    /**
     * @param int $iCompanyId
     * @param Batch $oBatch
     * @return string
     */
    public static function generateQrCodeForBatch(int $iCompanyId, Batch $oBatch): string
    {
        $aData =
            [
                'company_id' => $iCompanyId,
                'batch_id' => $oBatch->getId(),
                'dlc' => $oBatch->getDlc()->format('Y-m'),
                'quantity' => $oBatch->getQuantity(),
                'url' => 'http://localhost/Vendo_Logic/public/?page=vending&vending_id=' // TODO a modifier pour stock machine
            ];

        return ExternalQrCodeAPIService::generateQrCode($aData);
    }
}