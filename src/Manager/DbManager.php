<?php

namespace DaBuild\Manager;

class DbManager
{
    /** @var \PDO|null */
    private static ?\PDO $instance = NULL;

    /**
     * @return \PDO
     */
    public static function getInstance(): \PDO
    {
        if (!static::$instance instanceof \PDO) {
            $sDSN = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=UTF8';
            $aOptions = [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];

            $oPdo = new \PDO($sDSN, DB_USER, DB_PWD, $aOptions);

            if (ENV === 'development') {
                $oPdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
            }

            static::$instance = $oPdo;
        }
        return static::$instance;
    }

}