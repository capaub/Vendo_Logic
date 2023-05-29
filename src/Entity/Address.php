<?php

namespace DaBuild\Entity;

use DateTime;

class Address
{
    use Timestampable;

    /** @var int  */
    private int $id;
    /** @var string */
    private string $country;
    /** @var string */
    private string $city;
    /** @var string */
    private string $postalCode;
    /** @var string */
    private string $streetName;
    /** @var ?string */
    private ?string $streetNumber;
    /** @var int */
    private int $CompanyId;

    /**
     * @param string $sCountry
     * @param string $sCity
     * @param string $iPostalCode
     * @param string $sStreetName
     * @param string|null $sStreetNumber
     */
    public function __construct(
        string $sCountry,
        string $sCity,
        string $iPostalCode,
        string $sStreetName,
        ?string $sStreetNumber = NULL
    ) {
        $this->country = $sCountry;
        $this->city = $sCity;
        $this->postalCode = $iPostalCode;
        $this->streetName = $sStreetName;
        $this->streetNumber = $sStreetNumber;
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
     * @return Address
     */
    public function setId(int $id): Address
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Address
     */
    public function setCountry(string $country): Address
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Address
     */
    public function setCity(string $city): Address
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return Address
     */
    public function setPostalCode(string $postalCode): Address
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreetName(): string
    {
        return $this->streetName;
    }

    /**
     * @param string $streetName
     * @return Address
     */
    public function setStreetName(string $streetName): Address
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    /**
     * @param string|null $streetNumber
     * @return Address
     */
    public function setStreetNumber(?string $streetNumber): Address
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return $this->CompanyId;
    }

    /**
     * @param int $CompanyId
     * @return Address
     */
    public function setCompanyId(int $CompanyId): Address
    {
        $this->CompanyId = $CompanyId;
        return $this;
    }

}