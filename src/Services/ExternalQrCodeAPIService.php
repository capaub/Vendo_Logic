<?php

namespace DaBuild\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;


class ExternalQrCodeAPIService
{

    /**
     * @param array $aData
     * @return string
     */
    public static function generateQrCode(array $aData): string
    {
        $sDir = DIR_QR_IMG;
        $sData = $aData['url'];

        $sTags = $aData['customer_id'] ?? $aData['company_id'];

        if (!empty($aData['uniqid'])) {
            $sTags .= '@' . $aData['uniqid'];
        }

        if (!empty($aData['vending_id'])) {
            $sTags .= '@' . $aData['vending_id'];
            $sDir = DIR_QR_VENDING_IMG;
        }

        if (!empty($aData['batch_id'])) {
            $sTags .= '@' . $aData['batch_id'];
            $sDir = DIR_QR_BATCH_IMG;
        }

        $oPngWriter = new PngWriter();

        // Création du Qr Code
        $oQrCode = QrCode::create($sData)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Création du logo
//        $logo = Logo::create($sPath . $sTags . '.jpg')
//            ->setResizeToWidth(80);

        // Création du label
        //$label = Label::create('COUCOU')
        //    ->setTextColor(new Color(255, 0, 0));


        $oResult = $oPngWriter->write($oQrCode);

        // Validation du resultat
        //$writer->validateResult($result, 'https://wiki.openfoodfacts.org/API#Notice_for_API_users');

        $sPath = $sDir . '/' .  $sTags . '.jpg';

        $oResult->saveToFile($sPath);

        return $sPath;

    }

}