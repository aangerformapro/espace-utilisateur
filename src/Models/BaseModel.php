<?php

declare(strict_types=1);

namespace Models;

abstract class BaseModel
{
    public static function redirectTo(string $url)
    {
        header(sprintf('Location: %s', $url));

        exit;
    }

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

        static::createTable($pdo);

        return $pdo;
    }

    abstract protected static function createTable(\PDO $pdo);
}
