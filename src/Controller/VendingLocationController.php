<?php

namespace DaBuild\Controller;

class VendingLocationController extends AbstractController
{
    /**
     * @param array $location
     * @param int $i
     * @param int $j
     * @param array $aDisplayedLocations
     * @return array
     */
    function getVendingLocations(
        array $location,
        int   $i,
        int   $j,
        array &$aDisplayedLocations): array
    {
        $aVendingLocations = [];

        foreach ($location as $oLocation) {
            if ($oLocation->getLocation() === (NUM_TO_ALPHA[$i] . $j)) {
                if (!in_array($oLocation->getId(), $aDisplayedLocations)) {
                    $aDisplayedLocations[] = $oLocation->getId();
                    $aVendingLocations[] = $oLocation;
                }
            }
        }

        return $aVendingLocations;
    }
}