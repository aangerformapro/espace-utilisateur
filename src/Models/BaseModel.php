<?php

declare(strict_types=1);

namespace Models;

abstract class BaseModel
{
    protected static function getConnection(): \PDO
    {
        static $pdo;

        if ($pdo)
        {
            return $pdo;
        }

        $config = require_once dirname(__DIR__) . '/config.php';

        $pdo    = new \PDO(
            sprintf(
                'mysql:host=localhost;dbname=%s',
                $config['db']
            ),
            $config['user'],
            $config['password']
        );

        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}
