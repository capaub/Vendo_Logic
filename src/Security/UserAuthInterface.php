<?php

namespace DaBuild\Security;

interface UserAuthInterface
{
    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return string|null
     */
    public function getSalt(): ?string;
}