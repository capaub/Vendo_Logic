<?php

namespace DaBuild\Entity;

use DateTime;

class Customer
{

    use Timestampable;

    /** @var int */
    private int $id;
    /** @var string */
    private string $siret;
    /** @var string */
    private string $companyName;
    /** @var string */
    private string $email;
    /** @var string */
    private string $phone;
    /** @var string */
    private string $firstname;
    /** @var string */
    private string $lastname;
    /** @var int */
    private int $addressId;
    /** @var int */
    private int $companyId;

    /**
     * @param string $iSiret
     * @param string $sCompanyName
     * @param string $sMail
     * @param string $sPhone
     * @param string $sFirstname
     * @param string $sLastname
     * @param int $sAddressId
     * @param int $sCompanyId
     */
    public function __construct(string $iSiret,
                                string $sCompanyName,
                                string $sMail,
                                string $sPhone,
                                string $sFirstname,
                                string $sLastname,
                                int    $sAddressId,
                                int    $sCompanyId)
    {
        $this->siret = $iSiret;
        $this->companyName = $sCompanyName;
        $this->addressId = $sAddressId;
        $this->email = $sMail;
        $this->phone = $sPhone;
        $this->firstname = $sFirstname;
        $this->lastname = $sLastname;
        $this->companyId = $sCompanyId;
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
     * @return Customer
     */
    public function setId(int $id): Customer
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSiret(): string
    {
        return $this->siret;
    }

    /**
     * @param string $siret
     * @return Customer
     */
    public function setSiret(string $siret): Customer
    {
        $this->siret = $siret;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return Customer
     */
    public function setCompanyName(string $companyName): Customer
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Customer
     */
    public function setEmail(string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Customer
     */
    public function setPhone(string $phone): Customer
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return Customer
     */
    public function setFirstname(string $firstname): Customer
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return Customer
     */
    public function setLastname(string $lastname): Customer
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return int
     */
    public function getAddressId(): int
    {
        return $this->addressId;
    }

    /**
     * @param int $addressId
     * @return Customer
     */
    public function setAddressId(int $addressId): Customer
    {
        $this->addressId = $addressId;
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
     * @return Customer
     */
    public function setCompanyId(int $companyId): Customer
    {
        $this->companyId = $companyId;
        return $this;
    }

}