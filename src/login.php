<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';
session_start();

if (isset($_SESSION['USER']))
{
    header('Loaction: ./');

    exit;
}

echo loadView('login');
