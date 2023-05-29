<?php

namespace DaBuild\Entity;

use DateTime;

class VendingStock
{

    use Timestampable;

    /** @var int  */
    private int $id;
    /** @var int  */
    private int $quantity;
    /** @var int  */
    private int $batchesId;
    /** @var int  */
    private int $vendingLocationId;

    /**
     * @param int $iQuantity
     * @param int $iBatchesId
     * @param int $iVendingLocationId
     */
    public function __construct(int $iQuantity,
                                int $iBatchesId,
                                int $iVendingLocationId)
    {
        $this->quantity             = $iQuantity;
        $this->batchesId            = $iBatchesId;
        $this->vendingLocationId    = $iVendingLocationId;
        $this->updatedAt            = new DateTime('now');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return VendingStock
     */
    public function setId(int $id): VendingStock
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return VendingStock
     */
    public function setQuantity(int $quantity): VendingStock
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getBatchesId(): int
    {
        return $this->batchesId;
    }

    /**
     * @param int $batchesId
     * @return VendingStock
     */
    public function setBatchesId(int $batchesId): VendingStock
    {
        $this->batchesId = $batchesId;
        return $this;
    }

    /**
     * @return int
     */
    public function getVendingLocationId(): int
    {
        return $this->vendingLocationId;
    }

    /**
     * @param int $vendingLocationId
     * @return VendingStock
     */
    public function setVendingLocationId(int $vendingLocationId): VendingStock
    {
        $this->vendingLocationId = $vendingLocationId;
        return $this;
    }

}