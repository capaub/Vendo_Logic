<?php

namespace DaBuild\Entity;

use DateTime;

class VendingLocation
{

    use Timestampable;

    /** @var int  */
    private int $id;
    /** @var string  */
    private string $location;
    /** @var string  */
    private string $vendingId;

    public function __construct(string $sLocation, int $iVendingId)
    {
        $this->location = $sLocation;
        $this->vendingId= $iVendingId;
        $this->updatedAt    = new DateTime('now');
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
     * @return VendingLocation
     */
    public function setId(int $id): VendingLocation
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return VendingLocation
     */
    public function setLocation(string $location): VendingLocation
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getVendingId(): string
    {
        return $this->vendingId;
    }

    /**
     * @param string $vendingId
     * @return VendingLocation
     */
    public function setVendingId(string $vendingId): VendingLocation
    {
        $this->vendingId = $vendingId;
        return $this;
    }

}