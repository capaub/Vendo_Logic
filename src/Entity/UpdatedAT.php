<?php

namespace DaBuild\Entity;


use DateTime;

trait UpdatedAT
{

    /** @var DateTime */
    private DateTime $updatedAt;


    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return UpdatedAT|Batch|Company|Customer|Vending|VendingStock|User
     */
    public function setUpdatedAt(DateTime $updatedAt): UpdatedAT|Batch|Company|Customer|Vending|VendingStock|User
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}