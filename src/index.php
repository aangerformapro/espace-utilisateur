<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (null === ($user = getUser()))
{
    header('Location: ./login.php');

    exit;
}

echo loadView('index', [

    'pagetitle' => 'Hello',
    'user'      => $user,

]);
