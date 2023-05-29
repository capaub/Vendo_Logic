<?php

namespace DaBuild\Entity;

use DateTime;

class VendingPerCustomer
{

    /** @var int  */
    private int $id;
    /** @var string  */
    private string $status;
    /** @var DateTime  */
    private DateTime $installData;
    /** @var DateTime  */
    private DateTime $removalData;
    /** @var int  */
    private int $vendingId;
    /** @var int  */
    private int $customerId;

    const NOT_ASSIGNED = '0';
    const ASSIGNED = '1';

    const STATUS = [
        self::NOT_ASSIGNED => 'disponible',
        self::ASSIGNED => 'indisponible',
    ];

    /**
     * @param int $iVendingId
     * @param int $iCustomerId
     * @param string $sStatus
     */
    public function __construct(int $iVendingId,
                                int $iCustomerId,
                                string $sStatus = self::NOT_ASSIGNED)
    {
        $this->vendingId    = $iVendingId;
        $this->customerId   = $iCustomerId;
        $this->status       = $sStatus;
        $this->installData  = new DateTime('now');
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
     * @return VendingPerCustomer
     */
    public function setId(int $id): VendingPerCustomer
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return VendingPerCustomer
     */
    public function setStatus(string $status): VendingPerCustomer
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getInstallData(): DateTime
    {
        return $this->installData;
    }

    /**
     * @param DateTime $installData
     * @return VendingPerCustomer
     */
    public function setInstallData(DateTime $installData): VendingPerCustomer
    {
        $this->installData = $installData;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getRemovalData(): DateTime
    {
        return $this->removalData;
    }

    /**
     * @param DateTime $removalData
     * @return VendingPerCustomer
     */
    public function setRemovalData(DateTime $removalData): VendingPerCustomer
    {
        $this->removalData = $removalData;
        return $this;
    }

    /**
     * @return int
     */
    public function getVendingId(): int
    {
        return $this->vendingId;
    }

    /**
     * @param int $vendingId
     * @return VendingPerCustomer
     */
    public function setVendingId(int $vendingId): VendingPerCustomer
    {
        $this->vendingId = $vendingId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     * @return VendingPerCustomer
     */
    public function setCustomerId(int $customerId): VendingPerCustomer
    {
        $this->customerId = $customerId;
        return $this;
    }

}
