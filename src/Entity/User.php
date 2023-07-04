<?php

namespace DaBuild\Entity;

use DateTime;

class User
{

    use Timestampable;

    /** @var int */
    private int $id;
    /** @var string */
    private string $firstname;
    /** @var string */
    private string $lastname;
    /** @var string */
    private string $email;
    /** @var ?string */
    private ?string $password;
    /** @var string */
    private string $role;
    /** @var ?DateTime */
    private ?DateTime $connectedAt;
    /** @var int|null */
    private ?int $addressId;
    /** @var int */
    private int $companyId;


    public const ROLE_ADMIN = '1';
    /** voir enum */
    public const ROLE_SUPPLIER = '2';
    public const ROLE_CONF =
        [
            self::ROLE_ADMIN => ['label' => 'Admin'],
            self::ROLE_SUPPLIER => ['label' => 'Approvisionneur']
        ];


    /**
     * @param string $sFirstname
     * @param string $sLastname
     * @param string $sMail
     * @param int $iCompanyId
     * @param int|null $iAddressId
     * @param string|null $sPassword
     * @param string $sRole
     */
    public function __construct(string $sFirstname,
                                string $sLastname,
                                string $sMail,
                                int    $iCompanyId,
                                int    $iAddressId = NULL,
                                string $sPassword = NULL,
                                string $sRole = self::ROLE_SUPPLIER)
    {
        $this->firstname = $sFirstname;
        $this->lastname = $sLastname;
        $this->email = $sMail;
        $this->addressId = $iAddressId;
        $this->companyId = $iCompanyId;
        $this->password = $sPassword;
        $this->role = $sRole;
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
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
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
     * @return User
     */
    public function setFirstname(string $firstname): User
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
     * @return User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;
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
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return User
     */
    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return User
     */
    public function setRole(string $role): User
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getConnectedAt(): ?DateTime
    {
        return $this->connectedAt;
    }

    /**
     * @param DateTime|null $connectedAt
     * @return User
     */
    public function setConnectedAt(?DateTime $connectedAt): User
    {
        $this->connectedAt = $connectedAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAddressId(): ?int
    {
        return $this->addressId;
    }

    /**
     * @param int|null $addressId
     * @return User
     */
    public function setAddressId(?int $addressId): User
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
     * @return User
     */
    public function setCompanyId(int $companyId): User
    {
        $this->companyId = $companyId;
        return $this;
    }

}