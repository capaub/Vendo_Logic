<?php

namespace DaBuild\Services;


use OpenFoodFacts;
use OpenFoodFacts\Collection;
use OpenFoodFacts\Exception\BadRequestException;
use OpenFoodFacts\Exception\ProductNotFoundException;
use Psr\SimpleCache\InvalidArgumentException;

class ExternalOpenFoodFactAPIService
{
    /**
     * @param string $product
     * @return Collection|array
     * @throws BadRequestException
     * @throws InvalidArgumentException
     * @throws ProductNotFoundException
     */
    public static function findProductAPI(string $product): Collection|array
    {

        $api = new OpenFoodFacts\Api('food', 'fr');

        if (ctype_digit($product)) {
            return $api->getProduct($product)->getData();
        }

        return $api->search($product);

    }
}