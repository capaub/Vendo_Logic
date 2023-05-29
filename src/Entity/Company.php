<?php

namespace DaBuild\Entity;

use DateTime;

class Company
{

    use Timestampable;

    /** @var string  */
    private string $id;
    /** @var string  */
    private string $siret;
    /** @var string  */
    private string $name;


    /**
     * @param string $sName
     * @param string $iSiret
     */
    public function __construct(string $iSiret, string $sName)
    {
        $this->siret        = $iSiret;
        $this->name         = $sName;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Company
     */
    public function setId(string $id): Company
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
     * @return Company
     */
    public function setSiret(string $siret): Company
    {
        $this->siret = $siret;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Company
     */
    public function setName(string $name): Company
    {
        $this->name = $name;
        return $this;
    }

}