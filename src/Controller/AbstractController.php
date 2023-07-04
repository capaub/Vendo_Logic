<?php

namespace DaBuild\Controller;

use JetBrains\PhpStorm\NoReturn;

abstract class AbstractController
{
    /**
     * @param string $sUrl
     * @return void
     */
    #[NoReturn] protected function redirectAndDie(string $sUrl): void
    {
        header('Location: ' . $sUrl);
        die;
    }

    /**
     * @param string $sView
     * @param array $aParams
     * @param bool $bAjax
     * @return string
     */
    protected function render(string $sView, array $aParams = [], bool $bAjax = false): string
    {
        extract($aParams);

        ob_start();

        $sTemplate = __DIR__ . '/../../templates/base.php';

        if ($bAjax) {
            $sTemplate = __DIR__ . '/../../templates/' . $sView;
        }

        include $sTemplate;

        return ob_get_clean();
    }

}