<?php

namespace DaBuild\Entity;

use DateTime;

class Batch
{
    use Timestampable;

    /** @var int */
    private int $id;
    /** @var DateTime */
    private DateTime $dlc;
    /** @var int */
    private int $quantity;
    /** @var DateTime */
    private DateTime $soldOutAt;
    /** @var string */
    private string $qrCode;
    /** @var int */
    private int $goodsId;

    /**
     * @param DateTime $dlc
     * @param int $iQuantity
     * @param string $sQrCode
     * @param int $iGoodsId
     */
    public function __construct(
        DateTime $dlc,
        int      $iQuantity,
        string   $sQrCode,
        int      $iGoodsId
    )
    {
        $this->dlc = $dlc;
        $this->quantity = $iQuantity;
        $this->qrCode = $sQrCode;
        $this->goodsId = $iGoodsId;
        $this->updatedAt = new DateTime('now');
        $this->soldOutAt = new DateTime('now');
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
     * @return Batch
     */
    public function setId(int $id): Batch
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDlc(): DateTime
    {
        return $this->dlc;
    }

    /**
     * @param DateTime $dlc
     * @return Batch
     */
    public function setDlc(DateTime $dlc): Batch
    {
        $this->dlc = $dlc;
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
     * @return Batch
     */
    public function setQuantity(int $quantity): Batch
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getSoldOutAt(): DateTime
    {
        return $this->soldOutAt;
    }

    /**
     * @param DateTime $soldOutAt
     * @return Batch
     */
    public function setSoldOutAt(DateTime $soldOutAt): Batch
    {
        $this->soldOutAt = $soldOutAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getQrCode(): string
    {
        return $this->qrCode;
    }

    /**
     * @param string $qrCode
     * @return Batch
     */
    public function setQrCode(string $qrCode): Batch
    {
        $this->qrCode = $qrCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoodsId(): int
    {
        return $this->goodsId;
    }

    /**
     * @param int $goodsId
     * @return Batch
     */
    public function setGoodsId(int $goodsId): Batch
    {
        $this->goodsId = $goodsId;
        return $this;
    }

}