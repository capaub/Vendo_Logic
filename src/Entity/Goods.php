<?php

namespace DaBuild\Entity;

use DateTime;

class Goods
{

    use Timestampable;

    /** @var int */
    private int $id;
    /** @var string */
    private string $barcode;
    /** @var string */
    private string $brand;
    /** @var string */
    private string $img;
    /** @var string */
    private string $nutriScore;
    /** @var int */
    private int $companyId;

    /**
     * @param string $iBarcode
     * @param string $sBrand
     * @param string $sImg
     * @param string $sNutriScore
     * @param int $iCompanyId
     */
    public function __construct(string $iBarcode,
                                string $sBrand,
                                string $sImg,
                                string $sNutriScore,
                                int    $iCompanyId
    )
    {
        $this->barcode = $iBarcode;
        $this->brand = $sBrand;
        $this->img = $sImg;
        $this->nutriScore = $sNutriScore;
        $this->companyId = $iCompanyId;
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
     * @return Goods
     */
    public function setId(int $id): Goods
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     * @return Goods
     */
    public function setBarcode(string $barcode): Goods
    {
        $this->barcode = $barcode;
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
     * @return Goods
     */
    public function setBrand(string $brand): Goods
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     * @return Goods
     */
    public function setImg(string $img): Goods
    {
        $this->img = $img;
        return $this;
    }

    /**
     * @return string
     */
    public function getNutriScore(): string
    {
        return $this->nutriScore;
    }

    /**
     * @param string $nutriScore
     * @return Goods
     */
    public function setNutriScore(string $nutriScore): Goods
    {
        $this->nutriScore = $nutriScore;
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
     * @return Goods
     */
    public function setCompanyId(int $companyId): Goods
    {
        $this->companyId = $companyId;
        return $this;
    }

}