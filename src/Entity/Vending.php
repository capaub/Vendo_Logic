<?php

namespace DaBuild\Entity;

use DateTime;

class Vending
{

    use Timestampable;

    /** @var int */
    private int $id;
    /** @var string */
    private string $brand;
    /** @var string */
    private string $model;
    /** @var ?string */
    private ?string $name;
    /** @var int */
    private int $nbMaxTray;
    /** @var int */
    private int $nbMaxSpiral;
    /** @var ?string */
    private ?string $qrCode;
    /** @var int */
    private int $companyId;

    /**
     * @param string $sBrand
     * @param string $sModel
     * @param int $nbMaxTray
     * @param int $nbMaxSpiral
     * @param int $iCompanyId
     * @param string|null $sQrCode
     * @param string|null $sName
     */
    public function __construct(string  $sBrand,
                                string  $sModel,
                                int     $nbMaxTray,
                                int     $nbMaxSpiral,
                                int     $iCompanyId,
                                ?string $sQrCode = NULL,
                                ?string $sName = NULL)
    {
        $this->brand = $sBrand;
        $this->model = $sModel;
        $this->nbMaxTray = $nbMaxTray;
        $this->nbMaxSpiral = $nbMaxSpiral;
        $this->companyId = $iCompanyId;
        $this->qrCode = $sQrCode;
        $this->name = $sName;
        $this->updatedAt = new DateTime('now');
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
     * @return Vending
     */
    public function setId(int $id): Vending
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return Vending
     */
    public function setBrand(string $brand): Vending
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return Vending
     */
    public function setModel(string $model): Vending
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Vending
     */
    public function setName(?string $name): Vending
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbMaxTray(): int
    {
        return $this->nbMaxTray;
    }

    /**
     * @param int $nbMaxTray
     * @return Vending
     */
    public function setNbMaxTray(int $nbMaxTray): Vending
    {
        $this->nbMaxTray = $nbMaxTray;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbMaxSpiral(): int
    {
        return $this->nbMaxSpiral;
    }

    /**
     * @param int $nbMaxSpiral
     * @return Vending
     */
    public function setNbMaxSpiral(int $nbMaxSpiral): Vending
    {
        $this->nbMaxSpiral = $nbMaxSpiral;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    /**
     * @param string|null $qrCode
     * @return Vending
     */
    public function setQrCode(?string $qrCode): Vending
    {
        $this->qrCode = $qrCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    /**
     * @param int $companyId
     * @return Vending
     */
    public function setCompanyId(int $companyId): Vending
    {
        $this->companyId = $companyId;
        return $this;
    }

}