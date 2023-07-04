<?php

namespace DaBuild\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
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

        $oQrCode = QrCode::create($sData)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $oResult = $oPngWriter->write($oQrCode);

        $sPath = $sDir . '/' . $sTags . '.jpg';

        $oResult->saveToFile($sPath);

        return $sPath;

    }
}