<?php

namespace DaBuild\Entity;


use DateTime;

trait CreatedAt
{

    /** @var DateTime  */
    private DateTime $createdAt;


    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return CreatedAt|User|Vending|VendingStock|VendingLocation|Batch|Goods|Company|Customer
     */
    public function setCreatedAt(DateTime $createdAt): CreatedAt|User|Vending|VendingStock|VendingLocation|Batch|Goods|Company|Customer
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}